<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CobaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function preprocessing(Request $request)
    {
        //MENGAMBIL DATA DARI DATABASE KE DALAM VARIABEL ARRAY
        $nontarget   = DB::table('nontarget')->pluck('Kata_NonTarget')->toArray(); //UNTUK FILTERING
        $target      = DB::table('target')->pluck('Kata_Target')->toArray(); //
        
        //MENGAMBIL DATA INPUT - TOKENIZING - CASE FOLDING
        $str = $request->input_teks;
        $arr = explode(" ", $str);
        $arr = array_map('strtolower', $arr); //CASE FOLDING TO LOWERCASE

        //FILTER INPUT SEMUA YANG BERAWALAN MEM-
        $filter = array_filter($arr, function($var){
            return(stripos($var,'mem') !== false);
        });
        
        //FILTER INPUT BERAWALAN MEM- YANG TIDAK ADA DI TABEL NON_VERBA (TARGET UNTUK DIGANTI)
        $filterverb = array_diff(array_map("trim", $filter), array_map("trim", $nontarget));
        
        return $filterverb;

        //return view('index')->with(['str' => $str, 'filterverb' => $filterverb, 'filter' => $filter, 'nonverba' => $nonverba]);
    }

    private function getCommonCharacters( $string1, $string2, $allowedDistance ){

        $str1_len = mb_strlen($string1);
        $str2_len = mb_strlen($string2);
        $temp_string2 = $string2;

        $commonCharacters='';
        for( $i=0; $i < $str1_len; $i++){

            $noMatch = True;
            // compare if char does match inside given allowedDistance
            // and if it does add it to commonCharacters
            for( $j= max( 0, $i-$allowedDistance ); $noMatch && $j < min( $i + $allowedDistance + 1, $str2_len ); $j++){
                if( $temp_string2[$j] == $string1[$i] ){
                    $noMatch = False;
                    $commonCharacters .= $string1[$i];
                    $temp_string2[$j] = ' ';
                }
            }
        }
        return $commonCharacters;
    }

    private function Jaro( $string1, $string2 ){

        $str1_len = mb_strlen( $string1 );
        $str2_len = mb_strlen( $string2 );

        // theoretical distance
        $distance = (int) floor(min( $str1_len, $str2_len ) / 2.0); 

        // get common characters
        $commons1 = $this->getCommonCharacters( $string1, $string2, $distance );
        $commons2 = $this->getCommonCharacters( $string2, $string1, $distance );

        if( ($commons1_len = mb_strlen( $commons1 )) == 0) return 0;
        if( ($commons2_len = mb_strlen( $commons2 )) == 0) return 0;
        // calculate transpositions
        $transpositions = 0;
        $upperBound = min( $commons1_len, $commons2_len );
        for( $i = 0; $i < $upperBound; $i++){
            if( $commons1[$i] != $commons2[$i] ) $transpositions++;
        }
        $transpositions /= 2.0;
        // return the Jaro distance
        return ($commons1_len/($str1_len) + $commons2_len/($str2_len) + ($commons1_len - $transpositions)/($commons1_len)) / 3.0;

    }

    private function getPrefixLength( $string1, $string2, $MINPREFIXLENGTH = 4 ){

        $n = min( array( $MINPREFIXLENGTH, mb_strlen($string1), mb_strlen($string2) ) );

        for($i = 0; $i < $n; $i++){
            if( $string1[$i] != $string2[$i] ){
                // return index of first occurrence of different characters 
                return $i;
            }
        }
        // first n characters are the same   
        return $n;
    }

    public function JaroWinkler(Request $request, $PREFIXSCALE = 0.1 ){
        //MENGAMBIL DATA DARI DATABASE KE DALAM VARIABEL ARRAY
        $nontarget   = DB::table('nontarget')->pluck('Kata_NonTarget')->toArray(); //UNTUK FILTERING
        $target      = DB::table('target')->pluck('Kata_Target')->toArray(); //
        $target     = array_map("trim", $target);
        $nontarget     = array_map("trim", $nontarget);

        $str        = $request->input_teks;
        $arr        = explode(" ", $str);

        print_r($arr);
        echo "<br>";
        $hasil      = array();
        $filter_mem = 'mem';
        
        $filter = array_filter($arr, function($var){
            return(stripos($var,'mem') !== false);
        });
        
        $arr1 = array_diff(array_map("trim", $filter), array_map("trim", $nontarget));
        $arr1 = array_values($arr1);
        /* 
        print_r($arr1);
        echo "<br>"; */
        /* foreach($arr1 as $arry){
            echo "ini filter : ".$arry."<br>";
        } */

        
        /* foreach($arr1 as &$word){
            $word = strtolower($word);
            foreach($target as $verba){
                //$jwd = array();
                $JaroDistance = $this->Jaro( $word, $verba );
                $prefixLength = $this->getPrefixLength( $word, $verba );
                $jwd = $JaroDistance + $prefixLength * $PREFIXSCALE * (1.0 - $JaroDistance);
                //echo $verba."<br> ";
            }
            /* print_r($verba);
            print_r($jwd); */
            //$arrjwd = array_combine($target, $jwd);
            //print_r($arrjwd);
            //echo $max = max($jwd);
            //print_r($target);
        //}

        
        /* print_r($arr1);
        echo "<br>";
        $cek2 = array_replace($arr, $arr1);
        print_r($cek2);
 */
        /* $cek2 = array_merge($arr, $arr1);
        print_r($cek2) */;


        /* for($i = 0; $i<count($arr); $i++){ */
            for($i = 0; $i<count($arr1); $i++){
                $arr1[$i] = strtolower($arr1[$i]);
                for($j = 0; $j<count($target); $j++){
                    $JaroDistance = $this->Jaro( $arr1[$i], $target[$j] );
                    $prefixLength = $this->getPrefixLength( $arr1[$i], $target[$j] );
                    $jwd[$j] = $JaroDistance + $prefixLength * $PREFIXSCALE * (1.0 - $JaroDistance);
                }
                $arrjwd = array_combine($target, $jwd);
                $max = max($arrjwd);
                $key = array_search($max, $arrjwd);
                $kata[$i] = $key;
                $arr1[$i] = $kata[$i];
                echo $arr1[$i];
            }
        //}            
            print_r($arr1);
            echo "<br>";
            

            /* $cek = array_combine($arr, $arr1);
            print_r($cek); */

            /* $cek2 = array_replace($arr, $arr1);
            print_r($cek2);
            echo "<br>"; */
            //$cek2 = array_intersect($)
            /* for($x = 0; $x<count($arr1); $x++){
                //echo $arr1[$x];
                //$arr1[$x] = strtolower($arr1[$x]);
                //mencari nilai jwd tertinggi
                for($j = 0; $j<count($target); $j++){
                    $JaroDistance = $this->Jaro( $arr1[$x], $target[$j] );
                    $prefixLength = $this->getPrefixLength( $arr1[$x], $target[$j] );
                    $jwd[$j] = $JaroDistance + $prefixLength * $PREFIXSCALE * (1.0 - $JaroDistance);
                }
                $arrjwd = array_combine($target, $jwd);
                $max = max($arr1jwd);
                $key = array_search($max, $arr1jwd);
                $kata[$x] = $key;
                $arr1[$x] = $kata[$x]; */
            
        //}
        
        
        //$jml_kata   = count($hasil);
        

        /* $cek2 = array_merge($arr, $arr1);
        print_r($cek2); */

        /* $hasil = implode(" ", $arr);
        echo "output : ".$hasil; */

        //return $arr;
        //return view('output')->with(['arr' => $arr, 'katasalah' => $katasalah, 'hasil' => $hasil, 'arr' => $arr, 'jml_kata' => $jml_kata]);
    }

    
}
kata '{!!$inputsuggest[$i]!!}' perlu ditinjau.<br>
                    <p>Mungkin Maksud Anda : </p>
                        @php $count = 0 @endphp
                        
                        @for($j=0; $j<count($katasuggest); $j++)
                            @if($count == 3) @break @endif
                            <ul>
                                <li>{{ $katasuggest[$i] }}</li>
                            </ul>
                            @php $count++ @endphp
                        @endfor
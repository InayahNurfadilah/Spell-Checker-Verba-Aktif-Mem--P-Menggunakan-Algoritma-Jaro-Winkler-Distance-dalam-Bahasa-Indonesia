<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InputController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function verba()
    {
        $target = DB::table('target')->paginate(50);
        return view('verba-table')->with('target', $target);
    }

    public function cari(Request $request){
        $cari = $request->cari;
        $target = DB::table('target')->where('Kata_Target', 'LIKE', '%' . $cari . '%')-> orWhere('Kata_Dasar', 'LIKE', '%' . $cari . '%')->get();
        
        return view('cari')->with('target', $target);
    }

    public function tentang(){
        return view('tentang-kami');
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
        $str                = $request->input_teks;
        $input              = $str;
        $str                = strtolower($str);
        $arr                = explode(" ", $str);
        $target             = DB::table('target')->pluck('Kata_Target')->toArray();
        $target             = array_map("trim", $target);
        $nontarget          = DB::table('nontarget')->pluck('Kata_NonTarget')->toArray(); //UNTUK FILTERING
        $katasalah          = array();
        $katasuggest        = array();
        $inputsuggest       = array();
        $jml_katasuggest    = array();
        $jwdsuggest         = array();
        $jml_hasilsuggest   = array();
        

        $filter = array_filter($arr, function($var){
            return(stripos($var,'mem') !== false);
        });
        $arr1 = array_diff(array_map("trim", $filter), array_map("trim", $nontarget));
        $arr1 = array_values($arr1);
        

        for($i = 0; $i<count($arr); $i++){
            $arr[$i] = strtolower($arr[$i]); 
            for($x = 0; $x<count($arr1); $x++){
                if($arr[$i] == $arr1[$x]){
                   
                    //mencari nilai jwd tertinggi
                    for($j = 0; $j<count($target); $j++){
                        $JaroDistance = $this->Jaro( $arr[$i], $target[$j] );
                        $prefixLength = $this->getPrefixLength( $arr[$i], $target[$j] );
                        $jwd[$j] = $JaroDistance + $prefixLength * $PREFIXSCALE * (1.0 - $JaroDistance);
                    }
                    $arrjwd = array_combine($target, $jwd);
                    $max = max($arrjwd);
                    if($max >= 0.96 && $max < 1){
                        $key = array_search($max, $arrjwd);
                        $kata[$i] = $key;
                        $arr[$i] = $kata[$i];
                        $arr[$i] = "<b>$arr[$i]</b>";
                        $katasalah[] = $arr[$i];
                    }
                    else if($max >= 0.92 && $max < 0.96){
                        $jml_katasuggest[] = $arr[$i];
                        $suggest = $arrjwd;
                        arsort($suggest);
                        foreach($suggest as $key => $word){
                            if($word >= 0.92 && $word < 0.96){    
                                $kata[$i] = $key;
                                $arr[$i] = "<u>$arr[$i]</u>";
                                $inputsuggest[] = $arr[$i];
                                $katasuggest[] = $kata[$i];
                                $jwdsuggest[] = $word;
                            }
                        }
                    }
                }
            }
        }

        $jml_katasuggest    = count($jml_katasuggest);
        $jml_kata           = count($katasalah);
        $jml_hasilsuggest    = count($katasuggest);
        $hasil              = implode(" ", $arr);
/* 
        print_r($jwdsuggest);
        echo "NIlai jwd auto: ";
        print_r($max); */
        
        return view('output')->with([
            'input'             => $input,
            'arr1'              => $arr1,
            'hasil'             => $hasil, 
            'jml_kata'          => $jml_kata, 
            'str'               => $str, 
            'jml_katasuggest'   => $jml_katasuggest, 
            'katasuggest'       => $katasuggest,
            'inputsuggest'      => $inputsuggest,
            'jwdsuggest'        => $jwdsuggest,
            'jml_hasilsuggest'  => $jml_hasilsuggest
        ]);
    }

}
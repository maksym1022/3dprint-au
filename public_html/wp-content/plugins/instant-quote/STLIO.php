<?php

class STLIO
{

    //Properties
    //----------
    private $b_binary;
    private $fstl_handle;
    private $fstl_path;


    //Function defs
    //-------------


    //0. Contructor (PHP 5)
    /*
     * Initialises the STLIO class by passing the path to the .stl file.
     */
    function __construct($stl_file_path){
		$b = $this->isAscii($stl_file_path);
		if(! $b){
			// echo "BINARY STL Suspected.\n";
			$this->b_binary = TRUE;
			$this->fstl_handle = fopen($stl_file_path,"rb");    //Opens the STL file in binary mode for reading.
			$this->fstl_path = $stl_file_path;
		}else{
			// echo "ASCII STL Suspected.\n";
		}
    }


    /*
     * Checks if the given file is an ASCII file.
     */
    function isAscii($infilename){
        $b = FALSE;
        $facePattern =  '/facet\\s+normal\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+'
         . 'outer\\s+loop\\s+'
         . 'vertex\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+'
         . 'vertex\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+'
         . 'vertex\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+'
         . 'endloop\\s+' . 'endfacet/';
         #echo $facePattern;
        $fdata = file_get_contents($infilename);
        preg_match_all($facePattern, $fdata, $matches);
        if(sizeof($matches[0]) > 0){
            $b = TRUE;
        }
        return $b;
    }


    function _save_scaled_stl_ascii($infilename, $scale){

        $outfilename = $infilename.'.scaled.stl';

        $solid = ' solid '. $infilename;

        $facet_ascii = "facet normal -2.516451E-02 -5.610785E-01 -8.273799E-01
                            outer loop
                                vertex %E %E %E
                                vertex %E %E %E
                                vertex %E %E %E
                            endloop
                        endfacet";

        $facePattern =  '/facet\\s+normal\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+'
         . 'outer\\s+loop\\s+'
         . 'vertex\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+'
         . 'vertex\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+'
         . 'vertex\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+([-+]?\\b(?:[0-9]*\\.)?[0-9]+(?:[eE][-+]?[0-9]+)?\\b)\\s+'
         . 'endloop\\s+' . 'endfacet/';

        $fdata = file_get_contents($infilename);
        preg_match_all($facePattern, $fdata, $matches);
        // echo sizeof($matches[0]);
        $indices = array(4,5,6,7,8,9,10,11,12);
        $replacements = array();
        for ($i=0; $i < sizeof($matches[0]); $i++) {

            for ($j=0; $j < sizeof($indices); $j++) {
                $replacements[$j] = floatval($matches[ $indices[$j] ][$i]) * $scale;
            }

            $facet = vsprintf(
                                $facet_ascii,
                                $replacements
                    );
            $solid = $solid . '\n' . $facet;
        }

        $solid = $solid . '\n endsolid '. $infilename;
        file_put_contents($outfilename, $solid);

        echo "Created scaled STL in " . $outfilename;
    }

    function _my_unpack($sig, $l){
        $s = fread($this->fstl_handle, $l);
        $stuff = unpack($sig, $s);
        return $stuff;
    }

    function _read_header(){
        // fseek($this->fstl_handle, ftell($this->fstl_handle)+80);
        return $this->_my_unpack("a80", 80);
    }

    function _read_triangles_count(){
        $length = $this->_my_unpack("I",4);      
        return $length[1];
    }

    function _read_triangle(){
        $n  = $this->_my_unpack("f3", 12);
        $p1 = $this->_my_unpack("f3", 12);
        $p2 = $this->_my_unpack("f3", 12);
        $p3 = $this->_my_unpack("f3", 12);
        $b  = $this->_my_unpack("v", 2);
        return array(
                        1 => $n,
                        2 => array($p1,$p2,$p3),
                        3 => $b
                    );
    }

    function _save_scaled_stl_binary($infilename, $scale){

        $outfilename = $infilename.'.scaled'.$scale.'x.stl';
        $fp = fopen($outfilename, 'wb');
        $header = implode("", $this->_read_header());
        $bin_data = pack("a80", $header);

        $tricount = $this->_read_triangles_count();
        $bin_data .= pack("L",$tricount);

        for ($i=0; $i < $tricount; $i++) { 
            $triangle = $this->_read_triangle();
            // Normal [bytes = 12]
            $n = $triangle[1];
            $bin_data .= pack("f3", floatval($n[1]), floatval($n[2]), floatval($n[3]));
            $points = $triangle[2];
            // Three vertices [bytes = 36]
            for ($j=0; $j < sizeof($points); $j++) {
                $points[$j][1] = $points[$j][1] * $scale;
                $points[$j][2] = $points[$j][2] * $scale;
                $points[$j][3] = $points[$j][3] * $scale;
                $bin_data .= pack(
                                    "f3",
                                    floatval($points[$j][1]),
                                    floatval($points[$j][2]),
                                    floatval($points[$j][3])
                                );
            }
            // Attribute byte count [bytes = 2]
            $b = $triangle[3];
            $bin_data .= pack("v", $b);
        }

        fwrite($fp, $bin_data);
        fclose($fp);

        echo "Created scaled STL in " . $outfilename;
    }

    function save_scaled_stl($infilename, $scale){
        $b = $this->isAscii($infilename);
        if($b == TRUE){
            $this->_save_scaled_stl_ascii($infilename, $scale);
        }else{
            $this->_save_scaled_stl_binary($infilename, $scale);
        }
    }

}

//EXAMPLE//
//=======//
/*

// $mystlpath = "models/40mmcube.stl";
$mystlpath = "models/nut-ascii.stl";
$obj = new STLIO($mystlpath);
$scale = 2.0;
$obj->save_scaled_stl($mystlpath, $scale);

*/

?>
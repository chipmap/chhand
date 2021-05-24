<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<body>

<?php
// https://mygkgujrat.blogspot.com/2018/05/blog-post.html
// https://indaingk.blogspot.com/2019/07/chand.html
// https://kathiyawadikhamir.com/meaning-of-chhand/
//
// utf8 :   0x00 to   0x7f => 1 byte ascii
//        0x0080 to 0x07ff => 2 bytes 110x xxxx, 10xx xxxx
//        0x0800 to 0xffff => 3 bytes 1110 xxxx, 10xx xxxx, 10xx xxxx
//      0x1000 to 0x10ffff => 4 bytes 1111 0xxx, 10xx xxxx, 10xx xxxx, 10xx xxxx
//
// object(stdClass)#1 (1) { ["number"]=> string(81) "ગાલગાગા ગાલગાગા ગાલગાગા ગાલગા" } 
// ગાલગાગા ગાલગાગા ગાલગાગા ગાલગા----------
// e0 aa 97   e0 aa be   e0 aa b2   e0 aa 97   e0 aa be   e0 aa 97   e0 aa be   20
// e0 aa 97   e0 aa be   e0 aa b2   e0 aa 97   e0 aa be   e0 aa 97   e0 aa be   20
// e0 aa 97   e0 aa be   e0 aa b2   e0 aa 97   e0 aa be   e0 aa 97   e0 aa be   20
// e0 aa 97   e0 aa be   e0 aa b2   e0 aa 97   e0 aa be
//
// 1110 0000    1010 1010    1001 0111 => 0000 1010    1001 0111 => 0x0a97
//
// devnagari 0900-097f
// bengali 0980-09ff
// gurumukhi 0a00-0a7f
// gujarati 0a80-0aff
// oriya 0b00-0b7f
// tamil 0b80-0bff
// telugu 0c00-0c7f
// kannada 0c80-0cff
// malayalam 0d00-0d7f
// sinhala 0d80-0dff
// thai 0e00-0e7f
// lao 0e80-0eff
// tibetan 0f00-0fff
// myanmar 1000-109f
//

// place value 0 => meter value is applied to previous counter, counter is not incremented
//             1 => mater value is applied as is, counter is incremented
//             2 => meter value is applied as is to two places backward, counter is decremented

// gujarati map
//U+0A8x  	 ઁ	ં	ઃ		અ	આ	ઇ	ઈ	ઉ	ઊ	ઋ	ઌ	ઍ		એ
//U+0A9x  ઐ	ઑ		ઓ	ઔ	ક	ખ	ગ	ઘ	ઙ	ચ	છ	જ	ઝ	ઞ	ટ
//U+0AAx  ઠ	ડ	ઢ	ણ	ત	થ	દ	ધ	ન		પ	ફ	બ	ભ	મ	ય
//U+0ABx  ર		લ	ળ		વ	શ	ષ	સ	હ			઼	ઽ	ા	િ
//U+0ACx  ી	ુ	ૂ	ૃ	ૄ	ૅ		ે	ૈ	ૉ		ો	ૌ	્		
//U+0ADx  ૐ															
//U+0AEx  ૠ	ૡ	ૢ	ૣ			૦	૧	૨	૩	૪	૫	૬	૭	૮	૯
//U+0AFx  ૰	૱								ૹ	ૺ	ૻ	ૼ	૽	૾	૿

$gujaratiMeter = array( 0, 2, 1, 2, 0, 1, 2, 1, 2, 1, 2, 1, 1, 2, 0, 2,
                        2, 2, 0, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,
                        1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1,
                        1, 0, 1, 1, 0, 1, 1, 1, 1, 1, 0, 0, 2, 2, 2, 1,
                        2, 1, 2, 2, 2, 2, 0, 2, 2, 2, 0, 2, 2, 2, 0, 0,
                        3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                        2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                        0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 2, 2, 2, 2, 2 );

$gujaratiPlace = array( 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 1,
                        1, 1, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1,
                        1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1,
                        1, 0, 1, 1, 0, 1, 1, 1, 1, 1, 0, 0, 0, 2, 0, 0,
                        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0,
                        1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                        1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                        0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0 );

// devanagari map
//U+090x	ऀ	ँ	ं	ः	ऄ	अ	आ	इ	ई	उ	ऊ	ऋ	ऌ	ऍ	ऎ	ए
//U+091x	ऐ	ऑ	ऒ	ओ	औ	क	ख	ग	घ	ङ	च	छ	ज	झ	ञ	ट
//U+092x	ठ	ड	ढ	ण	त	थ	द	ध	न	ऩ	प	फ	ब	भ	म	य
//U+093x	र	ऱ	ल	ळ	ऴ	व	श	ष	स	ह	ऺ	ऻ	़	ऽ	ा	ि
//U+094x	ी	ु	ू	ृ	ॄ	ॅ	ॆ	े	ै	ॉ	ॊ	ो	ौ	्	ॎ	ॏ
//U+095x	ॐ	॑	॒	॓	॔	ॕ	ॖ	ॗ	क़	ख़	ग़	ज़	ड़	ढ़	फ़	य़
//U+096x	ॠ	ॡ	ॢ	ॣ	।	॥	०	१	२	३	४	५	६	७	८	९
//U+097x	॰	ॱ	ॲ	ॳ	ॴ	ॵ	ॶ	ॷ	ॸ	ॹ	ॺ	ॻ	ॼ	ॽ	ॾ	ॿ

$devanagariMeter = array( 2, 2, 1, 2, 2, 1, 2, 1, 2, 1, 2, 1, 2, 2, 2, 2,
                        2, 2, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,
                        1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,
                        1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 1,
                        2, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 2, 2, 1, 2,
                        3, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,
                        2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                        0, 1, 2, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1 );

$devanagariPlace = array( 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 1,
                        1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1,
                        1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,
                        1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0,
                        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0,
                        1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1,
                        1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                        0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1 );

// define variables and set to empty values
$debug = 0;
$orgText = "";
$result = "";
$matra = "";
$meter = array();
$bhasha = 0;
$color = array();
$letterCount = array();
$matraCount = array();
$matraType = 0;

$bhashaSuchi = array( "અણજાણ", "ગુજરાતી", "देवनागरी" );

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["lakhan"])) {
        $orgText = "";
    } else {
        $orgText = filterInput($_POST["lakhan"]);

        if (empty($_POST["matra"])) {
            $matra = "માત્રામેળ કે અક્ષરમેળનું ચયન કરો.";
            $matraType = 0;
        } else {
            $matra = filterInput($_POST["matra"]);
            if ($debug == 1) {
                echo "matra=" . $matra;
                echo "<br>";
            }
            $matraType = 1;
        }

        analyze();
        colorize();
    }

/*  if (empty($_POST["parinam"])) {
    $result = $orgText;
  } else {
    $result = filterInput($_POST["parinam"]);
  }*/

}

function filterInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function analyze()
{
    global $orgText, $result, $matra, $meter, $bhasha, $color, $bhashaSuchi, $matraType;
    global $debug, $gujaratiMeter, $gujaratiPlace, $devanagariMeter, $devanagariPlace;
    global $letterCount, $matraCount;


    /*$json = '{"number": "ગાલગાગા ગાલગાગા ગાલગાગા ગાલગા"}';

    $obj = json_decode($json);
    var_dump($obj);

    $string = $obj->number;
    */
    $string = $orgText;

//    echo $string;
//    echo '----------';

    $beg = 0;
    $hi = '';
    $lo = '';
    $letterIdx = 0;
    $matraIdx = 0;
    $gujarati = 0;
    $devnagari = 0;
    $meterValue = 0;
    $placeValue = 0;
    $correction = 0;
    $lineIdx = 0;
    $lineMeter = array();
    $maxMeterLength = 0;
    $absMeterIdx = array();
    $meterWidth = array();
    $spaceIdx = 0;

    $bhasha = $bhashaSuchi[0];

    for ($i = 0; $i < strlen($string); $i++) {
        $ch = ord($string[$i]);

        $meterValue = 0;
        $placeValue = 0;
        $correction = 0;

        if ($debug == 1)
            echo str_pad(dechex($ch), 2, '0', STR_PAD_LEFT);

        $color[$i] = 0;

        if ($ch < 0x80) {
            if (($ch == 0x0d) || ($ch == 0x0a)) {
                $color[$i] = 4; // new line
                // new line handling
                if ($letterIdx != 0) {
                    panktiPuri($lineIdx, $letterIdx, $matraIdx, $lineMeter, $absMeterIdx, $meterWidth);

                    $lineIdx += 1;
                    unset($lineMeter);
                    $lineMeter = array();
                    unset($absMeterIdx);
                    $absMeterIdx = array();
                    unset($meterWidth);
                    $meterWidth = array();
                }

                $letterIdx = 0;
                $matraIdx = 0;
            } else if ($ch == 0x20) {
                $spaceIdx = $i;
                //if (($letterIdx == 0) || (($letterIdx > 0) && ($lineMeter[$letterIdx - 1] != 0))) {
                //    $lineMeter[$letterIdx] = 0;
                //    $absMeterIdx[$letterIdx] = $i;
                //    $letterIdx += 1;
                //}
            }

            $beg = 0;

            if ($debug == 1) {
               echo "(-)<br>";
            }
        } else if (($ch & 0xe0) == 0xe0) {
            $beg = 1;
            $hi = ($ch & 0x0f) << 4;
        } else if (($ch & 0x80) == 0x80) {
            if ($beg == 1) {
                $beg = 2;
                $hi = $hi | (($ch & 0x3c) >> 2);
                $lo = ($ch & 0x03) << 6;
            } else if ($beg == 2) {
                $lo = $lo | ($ch & 0x3f);
                $beg = 0;
                
                if ($debug == 1) {
                    echo "(";
                    echo str_pad(dechex($hi), 2, '0', STR_PAD_LEFT);
                    echo str_pad(dechex($lo), 2, '0', STR_PAD_LEFT);
                    echo ")";
                }

                // set bhasha character if not set
                if (($hi == 0x0a) && ($lo >= 0x80)) {
                    $gujarati += 1;

                    $meterValue = $gujaratiMeter[$lo - 0x80];
                    $placeValue = $gujaratiPlace[$lo - 0x80];

                    if ($lo == 0xcd)
                        $correction = 1;
                } else if (($hi == 0x09) && ($lo < 0x80)) {
                    $devnagari += 1;

                    $meterValue = $devanagariMeter[$lo];
                    $placeValue = $devanagariPlace[$lo];

                }

                // process letter
                if ($debug == 1)
                    echo "{mtrv=" . $meterValue . ",plcv=" . $placeValue . ",ltrx=" . $letterIdx . ",spcx=" . $spaceIdx . "}";

                //$absMeterIdx[$letterIdx] = $spaceIdx;

                if ($placeValue == 0) {
                    if ($letterIdx > 0) {
                        $matraIdx -= $lineMeter[$letterIdx - 1];

                        if ($lineMeter[$letterIdx - 1] < 2) {
                            $lineMeter[$letterIdx - 1] = $meterValue;
                        }

                        $meterWidth[$letterIdx - 1] = $i - $absMeterIdx[$letterIdx - 1];;
                        $matraIdx += $meterValue;
                    }
                } else if ($placeValue == 2) {
                    if ($letterIdx > 1) {
                        $matraIdx -= $lineMeter[$letterIdx - 2];

                        if ($lineMeter[$letterIdx - 2] < 2) {
                            $lineMeter[$letterIdx - 2] = $meterValue;
                        }

                        $meterWidth[$letterIdx - 2] = $i - $absMeterIdx[$letterIdx - 2];;
                        $matraIdx += $meterValue;

                        $letterIdx -= 1;
                    } else if ($letterIdx == 1) {
                        $matraIdx -= $lineMeter[$letterIdx - 1];

                        if ($lineMeter[$letterIdx - 1] < 2) {
                            $lineMeter[$letterIdx - 1] = $meterValue;
                        }

                        $meterWidth[$letterIdx - 1] = $i - $absMeterIdx[$letterIdx - 1];;
                        $matraIdx += $meterValue;

                        $letterIdx = 0;
                    }
                } else {
                    $absMeterIdx[$letterIdx] = ($i > 1) ? $i - 2 : 0;

                    $matraIdx -= ($letterIdx < count($lineMeter)) ? $lineMeter[$letterIdx] : 0;

                    if ((count($lineMeter) <= $letterIdx) || ($lineMeter[$letterIdx] < 1)) {
                        $lineMeter[$letterIdx] = $meterValue;
                    }

                    $meterWidth[$letterIdx] = $i - $absMeterIdx[$letterIdx];
                    $matraIdx += $meterValue;

                    $letterIdx += 1;
                }
            }
        } else {
            $beg = 0;
        }

        echo ' ';
    }

    // check condition when new line character is not found
    if ($letterIdx > 0) {
        panktiPuri($lineIdx, $letterIdx, $matraIdx, $lineMeter, $absMeterIdx, $meterWidth);

       if ($debug == 1)
            echo "<br>";
    }

    // set bhasha
    if ($debug == 1)
        echo "guj=" . $gujarati . " dev=" . $devnagari;

    if (($gujarati > 0) || ($devnagari > 0)) {
        if ($gujarati >= $devnagari) {
            $bhasha = $bhashaSuchi[1];
        } else {
            $bhasha = $bhashaSuchi[2];
        }
    }

    // set average meter
    //$meterCount = array();
    //for ($line = 0; $line < $lineIdx; $line++) {
    //    if ($debug == 1)
    //        echo "[" . $line . "]=";
    //    for ($idx = 0; $idx < count($meter[$line]); $idx++) {
    //        $value = $meter[$line][$idx];
    //        if ($debug == 1)
    //            echo "(" . $value . ")";
    //        if ($value == 0)
    //            $meterCount[$idx] += 1;
    //        else if ($value == 1)
    //            $meterCount[$idx] += 100;
    //        else if ($value == 2)
    //            $meterCount[$idx] += 10000;
    //    }
    //
    //    if ($debug == 1)
    //        echo "<br>";
    //}

}

function panktiPuri($pankti, $akshar, $matra, $vidhan, $absPos, $absWidth)
{
    global $debug, $meter, $letterCount, $matraCount, $maxMeterLength, $matraType, $color;

    if ($debug == 1) {
        echo " meter[" .$pankti . "," . $akshar . "] = [";
        for ($y = 0; $y < $akshar; ++$y) {
            echo " " . $vidhan[$y] . " (" . $absPos[$y] . "," . $absWidth[$y] . ")";
        }
        echo "] akshar=" . $akshar . " matra=" . $matra;
    }

    $meter[$pankti] = $vidhan;
    $letterCount[$pankti] = $akshar;
    $matraCount[$pankti] = $matra;

    $vidhanCount = count($vidhan);
    $absPosCount = count($absPos);
    $absWidthCount = count($absWidth);
    // adjust max length
    if ($vidhanCount > $maxMeterLength)
        $maxMeterLength = count($vidhan);

    // check current meter with first meter
    $moveIdx = 0;
    $match = 1;

    for ($ydx = 0; ($ydx < $letterCount[0]) 
                    && ($moveIdx < $vidhanCount) 
                    && ($moveIdx < $absPosCount) 
                    && ($moveIdx < $absWidthCount); $ydx++) {
        $match = 1;

        if ($matraType == 1) {
            // akshar mel
            if ($ydx == ($letterCount[0] - 1)) {
                // last letter can be skipped if vidhan letter count is the same
                if ($ydx != $moveIdx) {
                    $match = 0;
                }
            } else {
                if ($meter[0][$ydx] != $vidhan[$moveIdx]) {
                    $match = 0;
                }
            }
        } else {
            // matra mel
            if ($meter[0][$ydx] == 1) {
                if ($vidhan[$moveIdx] == 2) {
                    // check if next in meter is 1
                    if (($ydx + 1) < $letterCount[0]) {
                        if ($meter[0][$ydx + 1] != 1) {
                            $match = 0;
                        } else {
                            $ydx++;
                        }
                    } else {
                        // last letter is fine
                    }
                }
            } else {
                if ($vidhan[$moveIdx] == 1) {
                    // check if next in vidhan is 1 as meter is 2
                    if (($moveIdx + 1) < $vidhanCount) {
                        if ($vidhan[$moveIdx + 1] != 1) {
                            $match = 0;
                        } else {
                            $moveIdx++;
                        }
                    } else {
                        // last letter is fine
                    }
                }
            }
        }

        if ($match == 0) {
            if ($debug == 1) {
                echo "-ERR-i=" . $moveIdx . " p=" . $absPos[$moveIdx] . " w=" .$absWidth[$moveIdx];
            }

            if ($moveIdx < ($letterCount[0] - 1)) {
                $color[$absPos[$moveIdx]] = 2; // start highlight
                $color[$absPos[$moveIdx] + $absWidth[$moveIdx]] = 3; // end highlight
            }

            //if ($moveIdx < ($letterCount[0] - 1)) {
            //    $color[$absPos[$moveIdx]] = 2; // start highlight
            //    $color[$absPos[$moveIdx + 1]] = 3; // end highlight
            //}

            $match = 1;
        }

        $moveIdx++;
    }
}

function colorize()
{
    global $result, $bhasha, $color, $meter, $orgText, $debug, $matraType, $letterCount;

    $result = "<p><b>લિપિ</b>: " . $bhasha;
    $result .= " <b>છંદ વિધાન</b>: ";

    for ($idx = 0; $idx < $letterCount[0]; $idx++) {
        if ($meter[0][$idx] == 0) $result .= "&nbsp;";
        else if ($meter[0][$idx] == 1) $result .= "લ";
        else if ($meter[0][$idx] == 2) $result .= "ગા";

        if ((($idx + 1) % 3) == 0) $result .= "&nbsp;";
    }

    if ($matraType == 1) {
        $result .= "(અક્ષરમેળ)";
    } else {
        $result .= " (માત્રામેળ)";
    }

    $result .= "</p>";
    $result .= "<p>-------------------------------------------------------------------------------------</p>";

    for ($idx = 0; $idx < strlen($orgText); ++$idx) {
        if ($color[$idx] == 2) {
            $result .= "<span style=\"background-color:rgb(255, 255, 0);\">";
        }

        $result .= $orgText[$idx];

        if ($color[$idx] == 3) {
            $result .= "</span>";
        } else if ($color[$idx] == 4) {
            $result .= "<br />";
        }
    }

    $result .= "<p>-------------------------------------------------------------------------------------</p>";
}

?>


<p>
<h1><img src="moon-small.jpg" width="30" height="30" /> સ્વરા વૃંદ ૧.૦ <img src="sun-small.jpg" width="30" height="30" /></h1>
utf8 છંદ ચકાસણી સાધન / Poem meter analyzer - Copyright &copy; 2021 <a href="http://rutmandal.info"  target="_blank" rel="noopener noreferrer">ચિરાગ પટેલ / Chirag Patel</a>
<br>
પ્રથમ પંક્તિને છંદ વિધાન ગણી ચકાસણી કરવામાં આવશે. 
</p>

<form id="padya" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<!-- input type="checkbox" id="matra" name="matramel" value="matra" -->
<input type="checkbox" name="matra"
<?php
global $matra, $matraType;
$matraType = isset($matra);
if (isset($matra) && $matra == "on") echo "checked";
?> 
value="on">
<label for="matramel"> અક્ષરમેળ માટે ક્લિક કરો અથવા માત્રામેળ પ્રમાણે પરિણામ આવશે </label>

<br>
<br>

<!-- button type="button" onclick="chakaso()"></button -->
<input type="submit" name="submit" value="ચકાસો / Analyze"> 
<button type="button" onclick="bhooso()">ભૂંસો / Clear</button>

<table>

    <tr>
        <th>લખો અથવા બીજેથી પેસ્ટ કરો. પછી, ચકાસણી બટન દબાવો.</th>
        <th></th>
        <th>પરિણામ</th>
    </tr>

    <tr>
        <td>
        <textarea id="lakhan" name="lakhan" rows="30" cols="60"><?php echo $orgText;?></textarea>
        </td>
        <td></td>
        <td>
        <!-- textarea id="parinam" name="parinam" rows="30" cols="60" readonly-->
        <!--?php echo $result;?-->
        <!--/textarea -->
        <?php echo $result;?>
        </td>

    </tr>

</table>

</form>

<p id="taran"></p>

<script>
function chakaso()
{
    var orgText = document.getElementById("lakhan").value;
    var destObj = document.getElementById("parinam");

    destObj.value = orgText;

    jQuery.ajax({
    type: "POST",
    url: 'chhand.php',
    dataType: 'json',
    data: {functionname: 'analyze_chhand', arguments: ["parinam", orgText]},

    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                      destObj.value = obj.result;
                  }
                  else {
                      console.log(obj.error);
                  }
            }
    });

}

function bhooso()
{
    document.getElementById("lakhan").value = '';
    document.getElementById("parinam").value = '';
}
</script>

</body>
</html>

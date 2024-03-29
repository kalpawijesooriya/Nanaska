<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/calculator.css" />


<script>

    var abc = "0";
    var def = 0;
    var ghi = 0;
    var jkl = 3;
    var mno = 0;
    var decimal = 0;
    var enter = "";
    function memory(operator) {
        document.pqr.stu.focus();
        if (operator == 1) {		// MS 
            document.pqr.mem.value = document.pqr.resultant.value;
        }
        else if (operator == 2) {	// MR
            var mem = document.pqr.mem.value;
            if (mem == 0 || chracter(mem.charAt(0))) {
                mem = "";
            }
            ;
            document.pqr.stu.value += mem;
        }
        else if (operator == 3) {	// CLS
            if (document.pqr.stu.value == "") {
                document.pqr.resultant.value = "";
            }
            else {
                document.pqr.stu.value = "";
            }
        }
    }
    function display(xyz) {
        if (xyz == "")
        {
            document.pqr.stu.focus();
        }
        else
        {
            document.pqr.resultant.select();
        }
    }
    function cdef(xyz) {
        document.pqr.stu.focus();
        document.pqr.stu.value += xyz;
    }
    function factorial(n) {
        if ((n == 0) || (n == 1)) {
            return 1;
        }
        else {
            var opqrst = (n * factorial(n - 1));
            return opqrst;
        }
    }
    function chracter(valuer) {
        var chracter = "(ABCDEFGHIKLMNOPRSTUVWXYZ";
        for (var i = 0; i < chracter.length; i++)
            if (valuer == chracter.charAt(i)) {
                return true;
            }
        {
            return false;
        }
    }
    function ghij(klmn) {
        var qrstu = "";
        var mem = 0;
        if (klmn >= 1) {
            if (document.pqr.stu.value == "") {
                abc = document.pqr.resultant.value;
            }
            else {
                abc = document.pqr.stu.value;
                if (resultant(abc.charAt(0))) {
                    abc = document.pqr.resultant.value + abc;
                }
            }
        }
        for (var i = 0; i < abc.length; i++) {
            if (abc.charAt(i) == ",") {
                qrstu += ".";
            }
            else if (abc.charAt(i) == " ") {
            }
            else {
                qrstu += abc.charAt(i);
            }
        }
        if (operator(abc.charAt(abc.length - 1))) {
            return false;
        }
        ;
        qrstu = eval("1*" + qrstu);
        if (klmn > 1) {
            qrstu = mathcalc(klmn, qrstu);
        }
        document.pqr.oldresultant.value = qrstu;
        result(qrstu);
        document.pqr.stu.value = "";
        document.pqr.stu.focus();
    }
    function mathcalc(klmn, mno) {
        with (Math)
        {
            if (klmn == 2) {
                mno = pow(mno, 2);
            }
            else if (klmn == 3) {
                mno = sqrt(mno);
            }
            else if (klmn == 4) {
                mno = -mno;
            }
            else if (klmn == 5) {
                mno = log(mno);
            }
            else if (klmn == 6) {
                mno = pow(E, mno);
            }
            else if (klmn == 7) {
                mno = 1 / mno;
            }
            else if (klmn == 8) {
                mno = log(mno) / LN10;
            }
            else if (klmn == 9) {
                mno = pow(10, mno);
            }
            else if (klmn >= 10 && klmn <= 12) {
                if (klmn == 10) {
                    mno = atan(mno);
                }
                else if (klmn == 11) {
                    mno = acos(mno);
                }
                else if (klmn == 12) {
                    mno = asin(mno);
                }
                if (document.pqr.vwxyz[1].checked) {
                    mno = (mno * 180) / PI;
                }
            }
            else if (klmn >= 14 && klmn <= 16) {
                if (document.pqr.vwxyz[1].checked)
                {
                    radian = (mno / 180) * PI;
                }
                else
                {
                    radian = mno;
                }
                ;
                if (klmn == 14) {
                    mno = tan(radian);
                }
                else if (klmn == 15) {
                    mno = cos(radian);
                }
                else if (klmn == 16) {
                    mno = sin(radian);
                }
            }
            else if (klmn == 17) {
                mno = mno / 100;
            }
            else if (klmn == 18) {
                mno = mno / 1000000;
            }
            else if (klmn == 20) {
                mno = factorial(mno);
            }
            else if (klmn == 21) {
                jkl = prompt("Kindly enter exponent", 3);
                mno = pow(mno, jkl);
            }
            else if (klmn == 22) {
                jkl = prompt("Kindly enter root", 3);
                mno = pow(mno, (1 / jkl));
            }
            return mno;
        }
    }
    function validatenum(data, e)
    {
        if (data.match(/^[a-zA-Z]+$/))
        {
            document.getElementById('stu').value = "";
            return false;
        }
        else
        {
            runScript(e);
            return true;
        }
    }
    function result(eabc) {
        decimal = parseFloat(document.pqr.xyzab.options[document.pqr.xyzab.selectedIndex].value);
        var strabc = eabc + " ";
        if (strabc.charAt(0) == ".") {
            strabc = "0" + strabc;
        }
        ;
        var intabc = strabc.length - 1;
        decklmn(strabc);
        if (intabc > 16 && ghi == -1) {
            if (decimal === -1) {
                decimal = 14;
            }
            ;
            strabc = xyzab(strabc.substring(0, intabc)) + " ";
            intabc = strabc.length - 1;
            decklmn(strabc);
        }
        if (decimal >= 0 && decimal != 14) {
            if (def > 0) {
                var opqrst = xyzab(strabc.substring(0, intabc));
            }
            else {
                eabc = strabc.substring(0, intabc);
                if (decimal > 0) {
                    eabc += ".";
                    for (var n = 0; n < decimal; n++) {
                        eabc += "0";
                    }
                }
                var opqrst = eabc;
            }
        }
        else {
            decimal = 14;
            var opqrst = xyzab(strabc);
        }
        if (opqrst.charAt(0) == ".") {
            opqrst = "0" + opqrst;
        }
        ;
        document.pqr.resultant.value = opqrst;
    }
    function decklmn(data1) {
        def = 0;
        ghi = 0;
        def = data1.indexOf(".");
        ghi = data1.indexOf("e");
    }
    function resultant(valuer) {
        var resultant = "*/+";
        for (var i = 0; i < resultant.length; i++)
            if (valuer == resultant.charAt(i)) {
                return true;
            }
        return false;
    }
    function xyzab(data1) {
        with (Math) {
            if (ghi == -1) {
                var value = def;
                if (value == -1) {
                    value = data1.length;
                }
                ;
                var value1 = "";
                if (value > 16) {
                    var value2 = round(data1 * pow(10, 18)) + " ";
                    var value3 = value2.indexOf("e");
                    var valuek = (value2.substring(0, value3));
                    valuek = round(valuek * pow(10, 15)) / pow(10, 15) + " ";
                    value1 = (value2.substring(value3 + 2, value2.length - 1));
                    value1 = "e+" + (value1 - 18);
                }
                else {
                    var valuek = round(data1 * pow(10, decimal)) / pow(10, decimal) + " ";
                }
            }
            else {
                var valuek = data1.substring(0, ghi);
                var value1 = data1.substring(ghi, data1.length);
                valuek = round(valuek * pow(10, decimal)) / pow(10, decimal) + " ";
            }

            valuek = valuek.substring(0, valuek.length - 1);
            if (valuek.charAt(0) == ".") {
                valuek = "0" + valuek;
            }
            ;
            if (decimal < 14) {
                if (valuek.indexOf(".") == -1 && decimal != 0) {
                    valuek += ".";
                }
                ;
                var nula = (def + decimal) - (valuek.length - 1);
                if (nula > 0 && decimal > 0) {
                    for (var n = 0; n < nula; n++) {
                        valuek += "0";
                    }
                }
            }
            return (valuek + " " + value1);
        }
    }
    function operator(valuer) {
        var dashop = "*/+-";
        for (var i = 0; i < dashop.length; i++)
            if (valuer == dashop.charAt(i)) {
                return true;
            }
        return false;
    }
    function backspace()
    {
        var input = document.getElementById('stu').value;
        var out = input.substring(0, input.length - 1);
        document.getElementById('stu').value = out;
    }
    function runScript(e) {
        if (e.keyCode == 13) {
            ghij(1);
        }
    }
    //    function ctck()
    //    {
    //        var sds = document.getElementById("dum");
    //        if(sds == null){
    //            alert("You are using a free package.\n You are not allowed to remove the tag.\n");
    //        }
    //        var sdss = document.getElementById("dumdiv");
    //        if(sdss == null){
    //            alert("You are using a free package.\n You are not allowed to remove the tag.\n");
    //        }
    //    }


</script>


<!--<body onLoad="ctck()">-->
<form name="pqr">
    <input type="hidden" name="oldresultant" value="">
    <input type="hidden" name="mem" value="">
    <div align="center">
        <table cellspacing=0 cellpadding=1 class='tabstyle'>
            <tr> 
                <td align="center" valign="middle"> 
                    <table  width="100%" cellspacing=3 cellpadding=1 class='innertable'>
                        <tr> 
                            <td align="center" valign="middle" width="100%"> 
                                <input type="text"  SIZE="16" name="resultant" value=""  readonly STYLE="font-size: 14pt; height: 30px; width: 249px">
                            </td>
                        </tr>
                    </table>
                    <table  cellspacing=3 cellpadding=0 class='innertable'>
                        <tr> 
                            <td colspan=5 align=center valign=middle> 
                                <SELECT style='display:none;' NAME=xyzab SIZE="1" onChange="if (document.pqr.oldresultant.value != '') {
                                                result(document.pqr.oldresultant.value);
                                            }
                                            ;
                                            document.pqr.stu.focus()">
                                    <OPTION VALUE=-1 SELECTED>decimal</OPTION>
                                </SELECT>
                                <input type="radio" name="vwxyz" checked title="Radians" onClick="document.pqr.stu.focus()"><a href="javascript:document.pqr.vwxyz[0].click()" style='text-decoration:none;' onMouseOver="self.status = 'Radians';
                                            return true">Rad</a>
                                <input type="radio" name="vwxyz" title="Degree" onClick="document.pqr.stu.focus()"><a href="javascript:document.pqr.vwxyz[1].click()"  style='text-decoration:none;' onMouseOver="self.status = 'Degrees';
                                            return true">Deg</a>
                                <input type="radio" name="vwxyz" title="Gradient" onClick="document.pqr.stu.focus()"><a href="javascript:document.pqr.vwxyz[2].click()" style='text-decoration:none;' onMouseOver="self.status = 'Degrees';
                                            return true">Grad</a>

                            </td>
                        </tr>
                        <tr> 
                            <td align=center valign=middle width="100%" colspan="5"> 
                                <input type="text" SIZE="17" name="stu" id="stu" value="" onkeyup='validatenum(this.value, event)' onChange="enter.click()"  STYLE="font-size: 10pt; font-weight: bold; height: 25px; width: 211px">
                            </td>
                            <td> 
                                <input type="button" name="Cls" value="Cls" TITLE="Clear screen" onClick="memory(3)" class='mathfun' style="width: 45px; height: 35px; padding-left: 5px;">
                            </td>
                        </tr>

                        <tr> 
                            <td > 
                                <input  type="button" name="sqrt" value="sqrt" title="Square root" onClick="ghij(3)" class='mathfun' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="root" value="root" title="Root" onClick="ghij(22)" class='mathfun' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="ln" value="ln" title="Natural logarithm" onClick="ghij(5)" class='mathfun' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="log" value="log" title="Common logarithm" onClick="ghij(8)" class='mathfun' style="width:48px;">
                            </td>
                            <td> 
                                <input  type="button" name="tan" value="tan" title="Tangent" onClick="ghij(14)" class='mathfun' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="atan" value="atan" title="Arc tangent" onClick="ghij(10)" class='mathfun' style="width:45px;">
                            </td>
                        </tr>

                        <tr> 
                            <td > 
                                <input  type="button" name="kvadrat" value="x^2" title="Square" onClick="ghij(2)" class='mathfun' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="potencija" value="x^y" title="Power" onClick="ghij(21)" class='mathfun' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="aln" value="e^x" title="Natural antilogarithm" onClick="ghij(6)" class='mathfun' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="alog" value="10^x" title="Common antilogarithm" onClick="ghij(9)" class='mathfun' align="left" style="width:48px;">
                            </td>
                            <td> 
                                <input  type="button" name="cos" value="cos" title="Cosine" onClick="ghij(15)" class='mathfun' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="acos" value="acos" title="Arc cosine" onClick="ghij(11)" class='mathfun' style="width:45px;">
                            </td>
                        </tr>

                        <tr> 
                            <td > 
                                <input  type="button" name="sign" value="+/-" title="Change sign" onClick="ghij(4)" class='mathfun' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="1/x" value="1/x" onClick="ghij(7)" class='mathfun' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="fact" value="x!" title="Factorial" onClick="ghij(20)" class='mathfun' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="PI" value="Pi" onClick="cdef(Math.PI)" class='mathfun' style="width:48px;"></td>
                            <td> 
                                <input  type="button" name="sin" value="sin" title="Sine" onClick="ghij(16)" class='mathfun' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="asin" value="asin" title="Arc sine" onClick="ghij(12)" class='mathfun' style="width:45px;">
                            </td>
                        </tr>

                        <tr> 
                            <td class="border_top border_left""> 
                                <input  type="button" name="7" value="7" onClick="cdef(7)" class='number' style="width:45px;">
                            </td>
                            <td class="border_top"> 
                                <input  type="button" name="8" value="8" onClick="cdef(8)" class='number' style="width:45px;">
                            </td>
                            <td style="width: 28px" class="border_top"> 
                                <input  type="button" name="9" value="9" onClick="cdef(9)" class='number' style="width:45px;">
                            </td>
                            <td style="width: 22px" class="border_top border_right"> 
                                <input  type="button" name="djeljeno" value="/" onClick="cdef('/')" class='number' style="width:47px;">
                            </td>
                            <td> 
                                <input  type="button" name="ppm" value="ppm" title="Part per milion" onClick="ghij(18)" class='mathfun1' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="MS" value="MS" title="Memory store" onClick="memory(1)" class='mathfun1' style="width:45px;">
                            </td>
                        </tr>

                        <tr> 
                            <td class="border_left"> 
                                <input  type="button" name="4" value="4" onClick="cdef(4)" class='number' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="5" value="5" onClick="cdef(5)" class='number' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="6" value="6" onClick="cdef(6)" class='number' style="width:45px;">
                            </td>
                            <td class="border_right"> 
                                <input  type="button" name="puta" value="*" onClick="cdef('*')" class='number' style="width:47px;">
                            </td>
                            <td> 
                                <input  type="button" name="postotak" value="%" title="Percent" onClick="ghij(17)" class='mathfun1' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="MR" value="MR" title="Memory recall" onClick="memory(2)" class='mathfun1' style="width:45px;">
                            </td>
                        </tr>

                        <tr> 
                            <td class="border_left"> 
                                <input  type="button" name="1" value="1" onClick="cdef(1)" class='number' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="2" value="2" onClick="cdef(2)" class='number' style="width:45px;">
                            </td>
                            <td > 
                                <input  type="button" name="3" value="3" onClick="cdef(3)" class='number' style="width:45px;">
                            </td>
                            <td class="border_right"> 
                                <input  type="button" name="minus" value="-" onClick="cdef('-')" class='number' style="width:47px;">
                            </td>
                            <td> 
                                <input  type="button" name="lijevo" value="(" onClick="cdef('(')" class='mathfun1' style="width:45px;">
                            </td>
                            <td> 
                                <input  type="button" name="desno" value=")" onClick="cdef(')')" class='mathfun1' style="width:45px;">
                            </td>
                        </tr>

                        <tr> 
                            <td class="border_left border_bottom"> 
                                <input  type="button" name="0" value="0" onClick="cdef(0)" class='number' style="width:45px;">
                            </td>
                            <td class="border_bottom"> 
                                <input  type="button" name="." value="." onClick="cdef('.')" class='number' style="width:45px;">
                            </td>
                            <td class="border_bottom"> 
                                <input  type="button" name="exp" value="E" onClick="cdef('e')" class='mathfun1' style="width:45px;">
                            </td>
                            <td class="border_bottom border_right"> 
                                <input  type="button" name="plus" value="+" onClick="cdef('+')" class='number' style="width:47px;">
                            </td>
                            <td COLSPAN=2> 
                                <input HEIGHT="32" type="button" name="enter" onClick="ghij(1)" value="=" STYLE="background: #CDCDCD; font-size: 12pt; height: 34px; width: 90px">
                            </td>
                        </tr>
                        <tr>
                            <td colspan='3'>
                                <input height="32" type="button" name="enter" onClick="ghij(1)" value="Enter" STYLE="background: #CDCDCD; font-size: 12pt; height: 32px; width: 135px">
                            </td>
                            <td colspan='3'>
                                <input height="32" type="button" name="Backspace" onClick="backspace()" value="Backspace" STYLE="background: #CDCDCD; font-size: 12pt; height: 32px; width: 138px">
                            </td>
                        </tr>   
                    </table>
                </td>
            </tr>
        </table>
    </div>
</form>



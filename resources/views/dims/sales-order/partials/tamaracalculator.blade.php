<div id="tamaraCalculator" title="Calculate" class="col-md-12">
    <form id="formID">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="calculator" style="width: 100%;">
                            <tr class="mb-2">
                                <td colspan="5">
                                    <input id="display" class="form-control mb-2" name="display" value="0"
                                        size="28" maxlength="25">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="button" class="btnTop btn btn-secondary btn-sm" name="btnTop" value="C"
                                        onclick="this.form.display.value=  0 ">
                                    </td>
                                <td>
                                    <input type="button" class="btnTop btn btn-secondary btn-sm" name="btnTop" value="<--"
                                        onclick="deleteChar(this.form.display)">
                                </td>
                                <td>
                                    <input type="button" id="equalOnCalculator" class="btnTop btn btn-secondary btn-sm" name="btnTop"
                                        value="="
                                        onclick="if(checkNum(this.form.display.value)) { compute(this.form) }">
                                </td>
                                <td>
                                    <input type="button" class="btnOpps btn btn-warning btn-sm" name="btnOpps" value="&#960;"
                                        onclick="addChar(this.form.display,'3.14159265359')">
                                </td>
                                <td>
                                    <input type="button" class="btnMath btn btn-danger btn-sm" name="btnMath" value="%"
                                        onclick=" percent(this.form.display)">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="button" class="btnNum btn btn-dark btn-sm" name="btnNum" value="7"
                                        onclick="addChar(this.form.display, '7')">
                                </td>
                                <td>
                                    <input type="button" class="btnNum btn btn-dark btn-sm" name="btnNum" value="8"
                                        onclick="addChar(this.form.display, '8')">
                                </td>
                                <td>
                                    <input type="button" class="btnNum btn btn-dark btn-sm" name="btnNum" value="9"
                                        onclick="addChar(this.form.display, '9')">
                                </td>
                                <td>
                                    <input type="button" class="btnOpps btn btn-warning btn-sm" name="btnOpps" value="x&#94;"
                                        onclick="if(checkNum(this.form.display.value)) { exp(this.form) }">
                                </td>
                                <td>
                                    <input type="button" class="btnMath btn btn-danger btn-sm" name="btnMath" value="/"
                                        onclick="addChar(this.form.display, '/')">
                                </td>
                            <tr>
                                <td>
                                    <input type="button" class="btnNum btn btn-dark btn-sm" name="btnNum" value="4"
                                        onclick="addChar(this.form.display, '4')">
                                </td>
                                <td>
                                    <input type="button" class="btnNum btn btn-dark btn-sm" name="btnNum" value="5"
                                        onclick="addChar(this.form.display, '5')">
                                </td>
                                <td>
                                    <input type="button" class="btnNum btn btn-dark btn-sm" name="btnNum" value="6"
                                        onclick="addChar(this.form.display, '6')">
                                </td>
                                <td>
                                    <input type="button" class="btnOpps btn btn-warning btn-sm" name="btnOpps" value="ln"
                                        onclick="if(checkNum(this.form.display.value)) { ln(this.form) }">
                                </td>
                                <td>
                                    <input type="button" class="btnMath btn btn-danger btn-sm" name="btnMath" value="*"
                                        onclick="addChar(this.form.display, '*')">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="button" class="btnNum btn btn-dark btn-sm" name="btnNum" value="1"
                                        onclick="addChar(this.form.display, '1')">
                                </td>
                                <td>
                                    <input type="button" class="btnNum btn btn-dark btn-sm" name="btnNum" value="2"
                                        onclick="addChar(this.form.display, '2')">
                                </td>
                                <td>
                                    <input type="button" class="btnNum btn btn-dark btn-sm" name="btnNum" value="3"
                                        onclick="addChar(this.form.display, '3')">
                                </td>
                                <td>
                                    <input type="button" class="btnOpps btn btn-warning btn-sm" name="btnOpps" value="&radic;"
                                        onclick="if(checkNum(this.form.display.value)) { sqrt(this.form) }">
                                </td>
                                <td>
                                    <input type="button" class="btnMath btn btn-danger btn-sm" name="btnMath" value="-"
                                        onclick="addChar(this.form.display, '-')">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="button" class="btnMath btn btn-danger btn-sm" name="btnMath" value="&#177"
                                        onclick="changeSign(this.form.display)">
                                </td>
                                <td>
                                    <input type="button" class="btnNum btn btn-dark btn-sm" name="btnNum" value="0"
                                        onclick="addChar(this.form.display, '0')">
                                </td>
                                <td>
                                    <input type="button" class="btnMath btn btn-danger btn-sm" name="btnMath" value="&#46;"
                                        onclick="addChar(this.form.display, '&#46;')">
                                </td>
                                <td>
                                    <input type="button" class="btnOpps btn btn-warning btn-sm" name="btnOpps" value="x&#50;"
                                        onclick="if(checkNum(this.form.display.value)) { square(this.form) }">
                                </td>
                                <td>
                                    <input type="button" class="btnMath btn btn-danger btn-sm" name="btnMath" value="+"
                                        onclick="addChar(this.form.display, '+')">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="button" class="btnMath btn btn-danger btn-sm" name="btnMath" value="("
                                        onclick="addChar(this.form.display, '(')">
                                </td>
                                <td>
                                    <input type="button" class="btnMath btn btn-danger btn-sm" name="btnMath" value=")"
                                        onclick="addChar(this.form.display,')')">
                                </td>
                                <td>
                                    <input type="button" class="btnMath btn btn-danger btn-sm" name="btnMath" value="cos"
                                        onclick="if(checkNum(this.form.display.value)) { cos(this.form) }">
                                </td>
                                <td>
                                    <input type="button" class="btnMath btn btn-danger btn-sm" name="btnMath" value="sin"
                                        onclick="if(checkNum(this.form.display.value)) { sin(this.form) }">
                                </td>
                                <td>
                                    <input type="button" class="btnMath btn btn-danger btn-sm" name="btnMath" value="tan"
                                        onclick="if(checkNum(this.form.display.value)) { tan(this.form) }">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#tamaraCalculator').hide();
        //simple calc
        $('#tamaraCalculatorId').click(function() {
            $('#tamaraCalculator').show();
            showDialog('#tamaraCalculator', 320, 400);
            $('#display').select();
        });
    });
    function addChar(input, character) {
        if(input.value == null || input.value == "0")
            input.value = character
        else
            input.value += character
    }

    function cos(form) {
        form.display.value = Math.cos(form.display.value);
    }

    function sin(form) {
        form.display.value = Math.sin(form.display.value);
    }

    function tan(form) {
        form.display.value = Math.tan(form.display.value);
    }

    function sqrt(form) {
        form.display.value = Math.sqrt(form.display.value);
    }

    function ln(form) {
        form.display.value = Math.log(form.display.value);
    }

    function exp(form) {
        form.display.value = Math.exp(form.display.value);
    }

    function deleteChar(input) {
        input.value = input.value.substring(0, input.value.length - 1)
    }
    var val = 0.0;
    function percent(input) {
        val = input.value;
        input.value = input.value + "%";
    }

    function changeSign(input) {
        if(input.value.substring(0, 1) == "-")
            input.value = input.value.substring(1, input.value.length)
        else
            input.value = "-" + input.value
    }

    function compute(form) {
        //if (val !== 0.0) {
        // var percent = form.display.value;
        // percent = pcent.substring(percent.indexOf("%")+1);
        // form.display.value = parseFloat(percent)/100 * val;
        //val = 0.0;
        // } else
        form.display.value = eval(form.display.value);
    }


    function square(form) {
        form.display.value = eval(form.display.value) * eval(form.display.value)
    }

    function checkNum(str) {
        for (var i = 0; i < str.length; i++) {
            var ch = str.charAt(i);
            if (ch < "0" || ch > "9") {
                if (ch != "/" && ch != "*" && ch != "+" && ch != "-" && ch != "."
                    && ch != "(" && ch!= ")" && ch != "%") {
                    alert("invalid entry!")
                    return false
                }
            }
        }
        return true
    }
</script>

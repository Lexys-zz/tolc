/*
 Interface based on
 http://benjaminsterling.com/password-strength-indicator-and-generator/

 modifications:
 * defaultClass added as passwordStrength option (passwordStrength can now easy re-initialized)
 * minchars added as passwordStrength option
 * getPasswordStrength uses the algorithm of http://mypocket-technologies.com/jquery/password_strength/
 * randomPassword chars became arguement
 * generate password became independed from main function
 * mask - unmask passwords added
 * triggerHandler() is used instead of trigger()

 Algorithm for password strength based on
 http://mypocket-technologies.com/jquery/password_strength/
 */
$.fn.passwordStrength = function (options) {
    return this.each(function () {
        var that = this;
        that.opts = {};
        that.opts = $.extend({}, $.fn.passwordStrength.defaults, options);

        that.div = $(that.opts.targetDiv);
        //that.defaultClass = that.div.attr('class');
        that.defaultClass = that.opts.defaultClass;

        that.percents = (that.opts.classes.length) ? 100 / that.opts.classes.length : 100;

        v = $(this)
            .keyup(function () {
/*                if (typeof el == "undefined")
                    this.el = $(this);*/
                if(that.opts.regexp) {
                    $(this).val($(this).val().replace(that.opts.regexp, ''));
                }

                //var s = getPasswordStrength(this.value);
                var s = getPasswordStrength(this.value, that.opts.username, that.opts.minchars);

                if(that.opts.strength_indicator) {
                    $("#" + that.opts.strength_indicator).html(s + '%');
                }

                var p = this.percents;
                var t = Math.floor(s / p);

                if (100 <= s)
                    t = this.opts.classes.length - 1;

                this.div
                    .removeAttr('class')
                    .addClass(this.defaultClass)
                    .addClass(this.opts.classes[ t ]);

            })
    });

    function getPasswordStrength_OLD(H) {
        var D = (H.length);
        if (D > 5) {
            D = 5
        }
        var F = H.replace(/[0-9]/g, "");
        var G = (H.length - F.length);
        if (G > 3) {
            G = 3
        }
        var A = H.replace(/\W/g, "");
        var C = (H.length - A.length);
        if (C > 3) {
            C = 3
        }
        var B = H.replace(/[A-Z]/g, "");
        var I = (H.length - B.length);
        if (I > 3) {
            I = 3
        }
        var E = ((D * 10) - 20) + (G * 10) + (C * 15) + (I * 10);
        if (E < 0) {
            E = 0
        }
        if (E > 100) {
            E = 100
        }
        return E
    }


    function getPasswordStrength(password, username, minchars) {

        var score = 0;

        //password < 4
        if (password.length < minchars) {
            return 0;
        }

        //password == user name
        if (password.toLowerCase() == username.toLowerCase()) {
            return 0;
        }

        //password length
        score += password.length * 4;
        score += ( $.fn.checkRepetition(1, password).length - password.length ) * 1;
        score += ( $.fn.checkRepetition(2, password).length - password.length ) * 1;
        score += ( $.fn.checkRepetition(3, password).length - password.length ) * 1;
        score += ( $.fn.checkRepetition(4, password).length - password.length ) * 1;

        //password has 3 numbers
        if (password.match(/(.*[0-9].*[0-9].*[0-9])/)) {
            score += 5;
        }

        //password has 2 symbols
        if (password.match(/(.*[!,@,#,$,%,^,&,*,?,_,~].*[!,@,#,$,%,^,&,*,?,_,~])/)) {
            score += 5;
        }

        //password has Upper and Lower chars
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
            score += 10;
        }

        //password has number and chars
        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
            score += 15;
        }
        //
        //password has number and symbol
        if (password.match(/([!,@,#,$,%,^,&,*,?,_,~])/) && password.match(/([0-9])/)) {
            score += 15;
        }

        //password has char and symbol
        if (password.match(/([!,@,#,$,%,^,&,*,?,_,~])/) && password.match(/([a-zA-Z])/)) {
            score += 15;
        }

        //password is just a numbers or chars
        if (password.match(/^\w+$/) || password.match(/^\d+$/)) {
            score -= 10;
        }

        //verifying 0 < score < 100
        if (score < 0) {
            score = 0;
        }
        if (score > 100) {
            score = 100;
        }

        return score;

    }

};

$.fn.passwordStrength.defaults = {
    defaultClass: 'is0',
    classes: Array('is10', 'is20', 'is30', 'is40', 'is50', 'is60', 'is70', 'is80', 'is90', 'is100'),
    targetDiv: '#passwordStrengthDiv',
    cache: {}
}

function randomPassword(chars, size) {
    var i = 1;
    var ret = ""
    while (i <= size) {
        $max = chars.length - 1;
        $num = Math.floor(Math.random() * $max);
        $temp = chars.substr($num, 1);
        ret += $temp;
        i++;
    }
    return ret;
}

$.fn.checkRepetition = function (pLen, str) {
    var res = "";
    for (var i = 0; i < str.length; i++) {
        var repeated = true;

        for (var j = 0; j < pLen && (j + i + pLen) < str.length; j++) {
            repeated = repeated && (str.charAt(j + i) == str.charAt(j + i + pLen));
        }
        if (j < pLen) {
            repeated = false;
        }
        if (repeated) {
            i += pLen - 1;
            repeated = false;
        }
        else {
            res += str.charAt(i);
        }
    }
    return res;
};


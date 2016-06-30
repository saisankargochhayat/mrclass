/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var _animated_css = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
/*###########################################################
 ###########    Global Method of Trim function     ###########
 ###########################################################*/
function trim(str, charlist) {
    var whitespace, l = 0,
        i = 0;
    str += '';

    if (!charlist) {
        // default list
        whitespace =
            ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
    } else {
        // preg_quote custom list
        charlist += '';
        whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
    }

    l = str.length;
    for (i = 0; i < l; i++) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(i);
            break;
        }
    }

    l = str.length;
    for (i = l - 1; i >= 0; i--) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(0, i + 1);
            break;
        }
    }

    return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
}
function ltrim(str, charlist) {
    charlist = !charlist ? ' \\s\u00A0' : (charlist + '').replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
    var re = new RegExp('^[' + charlist + ']+', 'g');
    return (str + '').replace(re, '');
}
/*###########################################################
 ###########    Global Method of Trim End          ###########
 ###########################################################*/
function empty(mixed_var) {
    var undef, key, i, len;
    var emptyValues = [undef, null, false, 0, '', '0'];

    for (i = 0, len = emptyValues.length; i < len; i++) {
        if (mixed_var === emptyValues[i]) {
            return true;
        }
    }

    if (typeof mixed_var === 'object') {
        for (key in mixed_var) {
            return false;
        }
        return true;
    }

    return false;
}

function substr(str, start, len) {
    var i = 0,
        allBMP = true,
        es = 0,
        el = 0,
        se = 0,
        ret = '';
    str += '';
    var end = str.length;

    // BEGIN REDUNDANT
    this.php_js = this.php_js || {};
    this.php_js.ini = this.php_js.ini || {};
    // END REDUNDANT
    switch ((this.php_js.ini['unicode.semantics'] && this.php_js.ini['unicode.semantics'].local_value.toLowerCase())) {
        case 'on':
            // Full-blown Unicode including non-Basic-Multilingual-Plane characters
            // strlen()
            for (i = 0; i < str.length; i++) {
                if (/[\uD800-\uDBFF]/.test(str.charAt(i)) && /[\uDC00-\uDFFF]/.test(str.charAt(i + 1))) {
                    allBMP = false;
                    break;
                }
            }

            if (!allBMP) {
                if (start < 0) {
                    for (i = end - 1, es = (start += end); i >= es; i--) {
                        if (/[\uDC00-\uDFFF]/.test(str.charAt(i)) && /[\uD800-\uDBFF]/.test(str.charAt(i - 1))) {
                            start--;
                            es--;
                        }
                    }
                } else {
                    var surrogatePairs = /[\uD800-\uDBFF][\uDC00-\uDFFF]/g;
                    while ((surrogatePairs.exec(str)) != null) {
                        var li = surrogatePairs.lastIndex;
                        if (li - 2 < start) {
                            start++;
                        } else {
                            break;
                        }
                    }
                }

                if (start >= end || start < 0) {
                    return false;
                }
                if (len < 0) {
                    for (i = end - 1, el = (end += len); i >= el; i--) {
                        if (/[\uDC00-\uDFFF]/.test(str.charAt(i)) && /[\uD800-\uDBFF]/.test(str.charAt(i - 1))) {
                            end--;
                            el--;
                        }
                    }
                    if (start > end) {
                        return false;
                    }
                    return str.slice(start, end);
                } else {
                    se = start + len;
                    for (i = start; i < se; i++) {
                        ret += str.charAt(i);
                        if (/[\uD800-\uDBFF]/.test(str.charAt(i)) && /[\uDC00-\uDFFF]/.test(str.charAt(i + 1))) {
                            // Go one further, since one of the "characters" is part of a surrogate pair
                            se++;
                        }
                    }
                    return ret;
                }
                break;
            }
            // Fall-through
        case 'off':
            // assumes there are no non-BMP characters;
            //    if there may be such characters, then it is best to turn it on (critical in true XHTML/XML)
        default:
            if (start < 0) {
                start += end;
            }
            end = typeof len === 'undefined' ? end : (len < 0 ? len + end : len + start);
            // PHP returns false if start does not fall within the string.
            // PHP returns false if the calculated end comes before the calculated start.
            // PHP returns an empty string if start and end are the same.
            // Otherwise, PHP returns the portion of the string from start to end.
            return start >= str.length || start < 0 || start > end ? !1 : str.slice(start, end);
    }
    // Please Netbeans
    return undefined;
}

function str_replace(search, replace, subject, count) {
    var i = 0,
        j = 0,
        temp = '',
        repl = '',
        sl = 0,
        fl = 0,
        f = [].concat(search),
        r = [].concat(replace),
        s = subject,
        ra = Object.prototype.toString.call(r) === '[object Array]',
        sa = Object.prototype.toString.call(s) === '[object Array]';
    s = [].concat(s);

    if (typeof (search) === 'object' && typeof (replace) === 'string') {
        temp = replace;
        replace = new Array();
        for (i = 0; i < search.length; i += 1) {
            replace[i] = temp;
        }
        temp = '';
        r = [].concat(replace);
        ra = Object.prototype.toString.call(r) === '[object Array]';
    }

    if (count) {
        this.window[count] = 0;
    }

    for (i = 0, sl = s.length; i < sl; i++) {
        if (s[i] === '') {
            continue;
        }
        for (j = 0, fl = f.length; j < fl; j++) {
            temp = s[i] + '';
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
            s[i] = (temp)
                .split(f[j])
                .join(repl);
            if (count) {
                this.window[count] += ((temp.split(f[j]))
                    .length - 1);
            }
        }
    }
    return sa ? s : s[0];
}

function preg_replace(pattern, pattern_replace, subject, limit) {
    if (limit === undefined) {
        limit = -1;
    }

    var _flag = pattern.substr(pattern.lastIndexOf(pattern[0]) + 1),
        _pattern = pattern.substr(1, pattern.lastIndexOf(pattern[0]) - 1),
        reg = new RegExp(_pattern, _flag),
        rs = null,
        res = [],
        x = 0,
        y = 0,
        ret = subject;

    if (limit === -1) {
        var tmp = [];

        do {
            tmp = reg.exec(subject);
            if (tmp !== null) {
                res.push(tmp);
            }
        } while (tmp !== null && _flag.indexOf('g') !== -1)
    } else {
        res.push(reg.exec(subject));
    }

    for (x = res.length - 1; x > -1; x--) { //explore match
        tmp = pattern_replace;

        for (y = res[x].length - 1; y > -1; y--) {
            tmp = tmp.replace('${' + y + '}', res[x][y])
                .replace('$' + y, res[x][y])
                .replace('\\' + y, res[x][y]);
        }
        ret = ret.replace(res[x][0], tmp);
    }
    return ret;
}
var tooltip = function (string, length, prefix) {
    var html = (prefix === "admin") ? '<span title="" rel="tooltip" data-placement="top" data-original-title="' + string + '">' + text_truncate(string, length, '...') + '</span>' : '<span title="' + string + '">' + text_truncate(string, length, '...') + '</span>';
    return html;
};
var text_truncate = function (str, length, ending) {
    if (length == null) {
        length = 100;
    }
    if (ending == null) {
        ending = '...';
    }
    if (str.length > length) {
        return str.substring(0, length - ending.length) + ending;
    } else {
        return str;
    }
};
var format_business_url = function (id, name, seo_url, full, allowed) {
    var full = full || true;
    var allowed = allowed || 'No';
    if (!empty(seo_url) && allowed != 'No') {
        return (full ? HTTP_ROOT : "") + seo_url_func(seo_url, '-');
    } else {
        return (full ? HTTP_ROOT : "") + 'b-' + id + '-' + seo_url_func(name, '-');
    }
};

function seo_url_func(string, flag) {
    var output;
    var string = string || '';
    var flag = flag || '-';
    string = substr(string, 0, 50);
    if (trim(string) != '') {
        if (flag == " ") {
            output = trim(preg_replace('/[^A-Za-z0-9.]+/ig', flag, string), flag);
            output = preg_replace('/\s+/', ' ', output);
            output = str_replace(" ", "_", output);
        } else {
            string = string.toLowerCase();
            output = trim(preg_replace('/[^A-Za-z0-9]+/ig', flag, string), flag);
        }
        return output;
    } else {
        return '';
    }
}
function explode(delimiter, string, limit) {
    if (arguments.length < 2 || typeof delimiter === 'undefined' || typeof string === 'undefined') return null;
    if (delimiter === '' || delimiter === false || delimiter === null) return false;
    if (typeof delimiter === 'function' || typeof delimiter === 'object' || typeof string === 'function' || typeof string ===
        'object') {
        return {
            0: ''
        };
    }
    if (delimiter === true) delimiter = '1';

    // Here we go...
    delimiter += '';
    string += '';

    var s = string.split(delimiter);

    if (typeof limit === 'undefined') return s;

    // Support for limit
    if (limit === 0) limit = 1;

    // Positive limit
    if (limit > 0) {
        if (limit >= s.length) return s;
        return s.slice(0, limit - 1)
            .concat([s.slice(limit - 1)
                .join(delimiter)
            ]);
    }

    // Negative limit
    if (-limit >= s.length) return [];

    s.splice(s.length + limit);
    return s;
}

var setCookie = function (c_name, c_value) {
    c_value = c_value + ";max-age=" + 60 * 3 + ";path=/";
    document.cookie = c_name + "=" + c_value;
}
var removeCookie = function (c_name) {
    if (!c_name)
        return null;
    document.cookie = c_name + "=;max-age=0;path=/";
}
var getCookie = function (c_name) {
    if (!c_name)
        return null;
    c_name = c_name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(c_name) == 0)
            return c.substring(c_name.length, c.length);
    }
    return null;
}

function format_phone_number(number) {
    number = preg_replace('/[^0-9]/g', '', number);
    if (number.length > 10) {
        var countryCode = substr(number, 0, strlen(number) - 10);
        var areaCode = substr(number, -10, 3);
        var nextThree = substr(number, -7, 3);
        var lastFour = substr(number, -4, 4);
        number = '+91' + ' ' + areaCode + ' ' + nextThree + '' + lastFour;
    } else if (number.length == 10) {
        var areaCode = substr(number, 0, 3);
        var nextThree = substr(number, 3, 3);
        var lastFour = substr(number, 6, 4);
        number = '+91- ' + areaCode + ' ' + nextThree + ' ' + lastFour;
    } else if (number.length == 7) {
        var nextThree = substr(number, 0, 3);
        var lastFour = substr(number, 3, 4);
        number = nextThree + '-' + lastFour;
    }
    return number;
}
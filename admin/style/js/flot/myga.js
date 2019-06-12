liveonlineusers_ga_obj = {    
    stopRecordingCookieName: "__liveonlineusers_no_record",

    checkPrivateHost: function () {
        var regex = /(^127\.0\.0\.1)|(^10\.)|(^172\.1[6-9]\.)|(^172\.2[0-9]\.)|(^172\.3[0-1]\.)|(^192\.168\.)/;
        var host = window.location.hostname;

        return regex.test(host);
    },

    checkIfContiuneRecording: function () {
        var result = true;

        if (this.getCookie(this.stopRecordingCookieName) == "1") {
            result = false;
        }

        return result;
    },

    getCookie: function (name) {
        var start = document.cookie.indexOf(name + "=");
        var len = start + name.length + 1;
        if ((!start) && (name != document.cookie.substring(0, name.length))) {
            return null;
        }
        if (start == -1) return null;
        var end = document.cookie.indexOf(';', len);
        if (end == -1) end = document.cookie.length;
        return unescape(document.cookie.substring(len, end));
    }
};


(function () {
    if(liveonlineusers_ga_obj.checkIfContiuneRecording()){	    
        if (!liveonlineusers_ga_obj.checkPrivateHost()) {
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-35429809-6', 'jqueryflottutorial.com');
            ga('send', 'pageview');
        }	    
    }
})();
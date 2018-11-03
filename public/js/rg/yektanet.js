!function(n){var o={};function r(e){if(o[e])return o[e].exports;var t=o[e]={i:e,l:!1,exports:{}};return n[e].call(t.exports,t,t.exports,r),t.l=!0,t.exports}r.m=n,r.c=o,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:n})},r.r=function(e){Object.defineProperty(e,"__esModule",{value:!0})},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=17)}([function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var d=o(n(3)),l=o(n(5)),s=o(n(2));function o(e){return e&&e.__esModule?e:{default:e}}var p;t.default=(p=!1,function(e,t,n){var o=s.default.getJSON("analytics_campaign"),r=s.default.get("analytics_session_token");e.abh=window.woebegone.analyticsConfig.advertiser.id,e.aaa=o.source,e.aab=o.medium,e.aac=o.content,e.aad=o.campaign,e.aae=o.term,e.abi=o.yn,e.ai=r;for(var a="https://ua.yektanet.com/__fake.gif?",i=Object.keys(e),u=0;u<i.length;u++)void 0!==e[i[u]]&&(0!==u&&(a+="&"),a+=i[u]+"="+encodeURIComponent(e[i[u]]));if(navigator.sendBeacon)navigator.sendBeacon(a),n&&n();else{var c=void 0;if(t){var f=(0,d.default)();(0,l.default)(f),c=document.getElementById(f)}else c=document.getElementById("aimg");c.src!==a&&(void 0!==n&&(setTimeout(function(){p||(p=!0,n())},1e3),c.addEventListener("load",function(){p||(p=!0,n())})),c.src=a)}})},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){var t=e.indexOf("#"),n=e.indexOf("?");if(-1!==t&&-1!==n&&t<n){var o=e.substr(0,t),r=e.substr(t,n-t),a=e.substr(n);e=o+a+r}var i=document.createElement("a");return{source:i.href=e,protocol:i.protocol.replace(":",""),host:i.hostname.replace(/^www\./,""),port:i.port,query:i.search,params:function(){for(var e={},t=i.search.replace(/^\?/,"").split("&"),n=t.length,o=0,r=void 0;o<n;o++)t[o]&&(e[(r=t[o].split("="))[0]]=r[1]);return e}(),file:(i.pathname.match(/\/([^/?#]+)$/i)||[,""])[1],hash:i.hash.replace("#",""),path:i.pathname.replace(/^([^/])/,"/$1"),relative:(i.href.match(/tps?:\/\/[^/]+(.+)/)||[,""])[1],segments:i.pathname.replace(/^\//,"").split("/")}}},function(o,r,a){var i,u;
    /*!
     * JavaScript Cookie v2.2.0
     * https://github.com/js-cookie/js-cookie
     *
     * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
     * Released under the MIT license
     */
    !function (e) {
        if (void 0 === (u = "function" == typeof(i = e) ? i.call(r, a, r, o) : i) || (o.exports = u), !0, o.exports = e(), !!0) {
            var t = window.Cookies, n = window.Cookies = e();
            n.noConflict = function () {
                return window.Cookies = t, n
            }
        }
    }(function () {
        function v() {
            for (var e = 0, t = {}; e < arguments.length; e++) {
                var n = arguments[e];
                for (var o in n) t[o] = n[o]
            }
            return t
        }
        return function e(p) {
            function m(e, t, n) {
                var o;
                if ("undefined" != typeof document) {
                    if (1 < arguments.length) {
                        if ("number" == typeof(n = v({path: "/"}, m.defaults, n)).expires) {
                            var r = new Date;
                            r.setMilliseconds(r.getMilliseconds() + 864e5 * n.expires), n.expires = r
                        }
                        n.expires = n.expires ? n.expires.toUTCString() : "";
                        try {
                            o = JSON.stringify(t), /^[\{\[]/.test(o) && (t = o)
                        } catch (e) {
                        }
                        t = p.write ? p.write(t, e) : encodeURIComponent(String(t)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent), e = (e = (e = encodeURIComponent(String(e))).replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent)).replace(/[\(\)]/g, escape);
                        var a = "";
                        for (var i in n) n[i] && (a += "; " + i, !0 !== n[i] && (a += "=" + n[i]));
                        return document.cookie = e + "=" + t + a
                    }
                    e || (o = {});
                    for (var u = document.cookie ? document.cookie.split("; ") : [], c = /(%[0-9A-Z]{2})+/g, f = 0; f < u.length; f++) {
                        var d = u[f].split("="), l = d.slice(1).join("=");
                        this.json || '"' !== l.charAt(0) || (l = l.slice(1, -1));
                        try {
                            var s = d[0].replace(c, decodeURIComponent);
                            if (l = p.read ? p.read(l, s) : p(l, s) || l.replace(c, decodeURIComponent), this.json) try {
                                l = JSON.parse(l)
                            } catch (e) {
                            }
                            if (e === s) {
                                o = l;
                                break
                            }
                            e || (o[s] = l)
                        } catch (e) {
                        }
                    }
                    return o
                }
            }
            return (m.set = m).get = function (e) {
                return m.call(m, e)
            }, m.getJSON = function () {
                return m.apply({json: !0}, [].slice.call(arguments))
            }, m.defaults = {}, m.remove = function (e, t) {
                m(e, "", v(t, {expires: -1}))
            }, m.withConverter = e, m
        }(function () {
        })
    })
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0}), t.default = function () {
        function e() {
            return Math.floor(65536 * (1 + Math.random())).toString(16).substring(1)
        }
        return e() + e() + "-" + e() + "-" + e() + "-" + e() + "-" + e() + e() + e()
    }
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0}), t.default = function () {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : location.href, t = (0, a.default)(e);
        return {url: e, host: t.host, parameters: JSON.stringify(t.params)}
    };
    var o, r = n(1), a = (o = r) && o.__esModule ? o : {default: o}
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0}), t.default = function (e) {
        if (!navigator.sendBeacon) {
            var t = document.createElement("img");
            t.id = e, t.src = "", t.style.display = "none", t.style.width = "1px", t.style.height = "1px", t.style.position = "absolute", document.body.appendChild(t)
        }
    }
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0}), t.default = function (e, t) {
        var n = !(2 < arguments.length && void 0 !== arguments[2]) || arguments[2];
        if ("function" != typeof e) throw new TypeError("C");
        r ? setTimeout(function () {
            e(t)
        }, 1) : (o.push({
            fn: e,
            ctx: t
        }), "complete" === document.readyState || n && navigator.sendBeacon ? setTimeout(i, 1) : a || (document.addEventListener ? (document.addEventListener("DOMContentLoaded", i, !1), window.addEventListener("load", i, !1)) : (document.attachEvent("onreadystatechange", u), window.attachEvent("onload", i)), a = !0))
    };
    var o = [], r = !1, a = !1;
    function i() {
        if (!r) {
            r = !0;
            for (var e = 0; e < o.length; e++) o[e].fn.call(window, o[e].ctx);
            o = []
        }
    }
    function u() {
        "complete" === document.readyState && i()
    }
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0}), t.default = function () {
        var e = 0 < arguments.length && void 0 !== arguments[0] && arguments[0], t = (0, i.default)(location.href),
            n = u.default.get("analytics_token"), o = {
                aa: "page",
                ab: "b815be79-a93b-4575-b83f-afd4acfc96ce",
                ac: t.url,
                ad: t.host,
                ae: t.parameters,
                ah: n,
                aj: window.woebegone.tabToken,
                al: window.innerWidth,
                am: window.innerHeight,
                as: document.title,
                av: location.protocol
            };
        if (e && document.referrer) {
            var r = (0, i.default)(document.referrer);
            o.af = r.url, o.ag = r.host
        }
        (0, a.default)(o, !1)
    };
    var a = o(n(0)), i = o(n(4)), u = o(n(2));
    function o(e) {
        return e && e.__esModule ? e : {default: e}
    }
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0}), t.default = function (e, t, n) {
        var o = (0, i.default)(location.href),
            r = {aa: "event", abe: e, abf: t, ac: o.url, ae: o.parameters, ad: o.host};
        (0, a.default)(r, !0, n)
    };
    var a = o(n(0)), i = o(n(4));
    function o(e) {
        return e && e.__esModule ? e : {default: e}
    }
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0});
    var i = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
        return typeof e
    } : function (e) {
        return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
    };
    t.default = function (e) {
        return e.filter(function (e) {
            var t = e.id;
            if (0 < document.querySelectorAll('[name="yn-tag"][id="' + t.toString() + '"]').length) return !0;
            for (var n, o = (0, u.default)(location.href), r = 0; r < e.patterns.length; r++) {
                var a = e.patterns[r];
                if (f(o.path, a) && (n = o.params, d(n, a.params))) return !0
            }
            return !1
        })
    };
    var o, r = n(1), u = (o = r) && o.__esModule ? o : {default: o};
    var c = RegExp("[" + ["-", "[", "]", "/", "{", "}", "(", ")", "*", "+", "?", ".", "\\", "^", "$", "|"].join("\\") + "]", "g");
    function f(e, t) {
        var n = void 0;
        if ("R" === t.type) n = RegExp(t.query, "ui"); else {
            var o = t.query.replace(c, "\\$&"), r = -1 !== ["S", "="].indexOf(t.type) ? "^" : ".*",
                a = -1 !== ["E", "="].indexOf(t.type) ? "$" : ".*";
            n = RegExp(r + o + a)
        }
        return n.test(decodeURI(e))
    }
    var d = function o(r, a) {
        return "object" === (void 0 === r ? "undefined" : i(r)) && null !== r && "object" === (void 0 === a ? "undefined" : i(a)) && null !== a && (r instanceof Date || a instanceof Date ? r.valueOf() === a.valueOf() : Object.keys(a).every(function (e) {
            if (!r.propertyIsEnumerable(e)) return !1;
            var t = a[e], n = r[e];
            return !("object" === (void 0 === t ? "undefined" : i(t)) && null !== t ? !o(n, t) : n !== t)
        }))
    }
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0}), t.default = function () {
        var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : window.woebegone.analyticsConfig.advertiser.tags;
        window.onpopstate = history.onpushstate = function (e) {
            try {
                d.forEach(function (e) {
                    return clearInterval(e)
                }), d = [], l.forEach(function (e) {
                    return clearInterval(e)
                }), l = [], s.forEach(function (e) {
                    return e.removeEventListener("click")
                }), s = [], p.forEach(function (e) {
                    return clearInterval(e)
                }), p = [], m.forEach(function (e) {
                    return e.removeEventListener("submit")
                }), m = [], v((0, o.default)(t)), (0, a.default)()
            } catch (e) {
            }
        }, v((0, o.default)(t))
    };
    var i = u(n(8)), o = u(n(9)), r = u(n(6)), a = u(n(7));
    function u(e) {
        return e && e.__esModule ? e : {default: e}
    }
    var c, f, d = [], l = [], s = [], p = [], m = [];
    function v(e) {
        var t, n, o;
        !function (e) {
            var t = !0, n = !0, o = 0;
            try {
                window.addEventListener("blur", function () {
                    return t = !1
                }), window.addEventListener("focus", function () {
                    return t = !0
                })
            } catch (e) {
            }
            setInterval(function () {
                try {
                    n = !document.hidden
                } catch (e) {
                }
                t && n && (o += 1e3)
            }, 1e3), e && e.forEach && e.forEach(function (e) {
                var t = setInterval(function () {
                    o >= 1e3 * e.event.time_on_page_threshold && ((0, i.default)("T", e.id), clearInterval(t))
                }, 1e3);
                d.push(t)
            })
        }(e.filter(function (e) {
            return "T" === e.event.type
        })), (t = e.filter(function (e) {
            return "L" === e.event.type
        })) && t.forEach && t.forEach(function (e) {
            (0, i.default)("L", e.id)
        }), (n = e.filter(function (e) {
            return "C" === e.event.type
        })) && n.forEach && n.forEach(function (r) {
            var a = setInterval(function () {
                var e, t, n = r.event.css_selector, o = document.querySelectorAll(n);
                0 < o.length && (e = o, t = r.id, e && e.forEach && e.forEach(function (e) {
                    e.addEventListener("click", function () {
                        return (0, i.default)("C", t)
                    }), s.push(e)
                }), clearInterval(a))
            }, 2e3);
            l.push(a)
        }), function (e) {
            (0, r.default)(function () {
                return e && e.forEach && e.forEach(function (e) {
                    return e && e.event && e.event.custom_script && e.event.custom_script()
                })
            }, this, !1)
        }(e.filter(function (e) {
            return "U" === e.event.type
        })), (o = e.filter(function (e) {
            return "S" === e.event.type
        })) && o.forEach && o.forEach(function (r) {
            var a = setInterval(function () {
                var e, t, n = r.event.css_selector, o = document.querySelectorAll(n);
                0 < o.length && (o = Array.from(o).map(function (e) {
                    for (; e && "FORM" !== e.nodeName;) e = e.parentNode;
                    return e
                }).filter(Boolean), e = o, t = r.id, e && e.forEach && e.forEach(function (e) {
                    e.addEventListener("submit", function (e) {
                        (0, i.default)("S", t)
                    }), m.push(e)
                }), clearInterval(a))
            }, 2e3);
            p.push(a)
        })
    }
    c = window.history, f = c.pushState, c.pushState = function (e) {
        var t = f.apply(c, arguments);
        return "function" == typeof c.onpushstate && c.onpushstate({state: e}), t
    }
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0}), t.default = function () {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : location.href,
            t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : document.referrer,
            n = (0, l.default)(e), o = n.params;
        function r(e, t, n, o, r, a) {
            return {source: e, medium: t, campaign: n, content: o, term: r, yn: a}
        }
        if (o.gclid || o.gclsrc) return r("google", "cpc", "adwords", "adwords");
        if (o.campaignSource) return r(decodeURIComponent(o.campaignSource), o.campaignMedium && decodeURIComponent(o.campaignMedium), o.campaignName && decodeURIComponent(o.campaignName), o.campaignContent && decodeURIComponent(o.campaignContent), o.campaignTerm && decodeURIComponent(o.campaignTerm), o.campaignYn && decodeURIComponent(o.campaignYn));
        if (o.utm_source) return r(decodeURIComponent(o.utm_source), o.utm_medium && decodeURIComponent(o.utm_medium), o.utm_campaign && decodeURIComponent(o.utm_campaign), o.utm_content && decodeURIComponent(o.utm_content), o.utm_term && decodeURIComponent(o.utm_term), o.utm_yn && decodeURIComponent(o.utm_yn));
        if (o.wg_source) return r(decodeURIComponent(o.wg_source), o.wg_medium && decodeURIComponent(o.wg_medium), o.wg_campaign && decodeURIComponent(o.wg_campaign), o.wg_content && decodeURIComponent(o.wg_content), o.wg_term && decodeURIComponent(o.wg_term), o.utm_yn && decodeURIComponent(o.utm_yn));
        if (t) {
            var a = (0, l.default)(t);
            if (a.host.endsWith("shaparak.ir")) return r("direct", null);
            var i = ["google", "bing", "yahoo", "ask", "aol", "baidu"], u = a.host.split("."), c = u[u.length - 2],
                f = u[u.length - 3];
            if (-1 !== i.indexOf(c)) return r(c, "organic");
            if (-1 !== i.indexOf(f)) return r(f, "organic");
            if (a.host !== n.host) {
                if (a.protocol.startsWith("android-app")) {
                    var d = t.split("/");
                    return 2 < d.length ? r(d[2].split(".").reverse().join("."), "referral") : r(t, "referral")
                }
                return r(a.host, "referral")
            }
        }
        return r("direct", null)
    };
    var o, r = n(1), l = (o = r) && o.__esModule ? o : {default: o}
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0}), t.default = function () {
        var e = "analytics_session_token", t = "analytics_token", n = "analytics_campaign",
            o = (0, d.default)(location.href), r = f.default.getJSON(n),
            a = !r || (o.source !== r.source || o.medium !== r.medium || o.campaign !== r.campaign || o.content !== r.content || o.term !== r.term || o.yn !== r.yn) && "direct" !== o.source;
        a && f.default.set(n, o, {expires: 365});
        var i = a ? (0, c.default)() : f.default.get(e) || (0, c.default)();
        f.default.set(e, i, {expires: 1 / 48});
        var u = f.default.get(t);
        u || (u = "undefined" != typeof Storage && localStorage.getItem(t) || (0, c.default)());
        f.default.set(t, u, {expires: 365}), "undefined" != typeof Storage && localStorage.setItem(t, u)
    };
    var c = o(n(3)), f = o(n(2)), d = o(n(11));
    function o(e) {
        return e && e.__esModule ? e : {default: e}
    }
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0}), t.default = function (t) {
        var e = window.woebegone.analyticsConfig.advertiser.tags.find(function (e) {
            return e.id === t
        });
        {
            if (!e) throw'wrong tag id: "' + t + '"';
            (0, a.default)(e.event.type, e.id)
        }
    };
    var o, r = n(8), a = (o = r) && o.__esModule ? o : {default: o}
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0}), t.default = function (e, t) {
        if (!e) throw"userId is required!";
        var n = {aa: "user", add: e};
        t && t instanceof Object && (o = t, r = u, a = {}, Object.keys(o).forEach(function (e) {
            if (!(e in r)) throw'wrong key for yektanet api: "' + e + '"';
            a[r[e]] = o[e]
        }), t = a, Object.assign(n, t));
        var o, r, a;
        (0, i.default)(n)
    };
    var o, r = n(0), i = (o = r) && o.__esModule ? o : {default: o};
    var u = {action: "ada", name: "adb", fullname: "adb", email: "adc", country: "ade", city: "adf", sex: "adg"}
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0});
    var f = function (e, t) {
        if (Array.isArray(e)) return e;
        if (Symbol.iterator in Object(e)) return function (e, t) {
            var n = [], o = !0, r = !1, a = void 0;
            try {
                for (var i, u = e[Symbol.iterator](); !(o = (i = u.next()).done) && (n.push(i.value), !t || n.length !== t); o = !0) ;
            } catch (e) {
                r = !0, a = e
            } finally {
                try {
                    !o && u.return && u.return()
                } finally {
                    if (r) throw a
                }
            }
            return n
        }(e, t);
        throw new TypeError("Invalid attempt to destructure non-iterable instance")
    }, o = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
        return typeof e
    } : function (e) {
        return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
    };
    t.default = function (e, t) {
        var n = (0, a.default)(location.href);
        e = function (e) {
            if (e = e.toLowerCase(), -1 !== u.indexOf(e)) return e;
            throw"action should be one of (" + u.join(", ") + ")"
        }(e), (t = function (a, i) {
            var u = {};
            function c(e) {
                return e
            }
            return Object.keys(a).forEach(function (e) {
                if (!(e in i)) throw'wrong key for yektanet api: "' + e + '"';
                var t = i[e], n = void 0, o = void 0;
                if (Array.isArray(t)) {
                    var r = f(t, 2);
                    n = r[0], o = r[1]
                } else n = t, o = c;
                u[n] = o(a[e])
            }), u
        }(t, d)).acm = e, t.aa = "product", t.ac = n.url, t.ad = n.host, (0, r.default)(t)
    };
    var r = i(n(0)), a = i(n(4));
    function i(e) {
        return e && e.__esModule ? e : {default: e}
    }
    var u = ["detail", "add", "remove", "vote", "comment", "wishlist", "purchase", "refund"];
    function c(e) {
        return Array.isArray(e) ? e.join(",") : e
    }
    var d = {
        title: "aca",
        sku: "acb",
        category: ["acc", c],
        subCategory: ["acp", c],
        quantity: "acd",
        price: "ace",
        currency: "acf",
        brand: "acg",
        discount: "ach",
        comment: "aci",
        vote: "acj",
        averageVote: "ack",
        totalVotes: "acl",
        cartId: "acn",
        image: "aco",
        isAvailable: ["acq", function (e) {
            return "boolean" == typeof e ? e ? "1" : "0" : e
        }],
        expiration: ["acr", function (e) {
            return e && e.getTime ? e.getTime() : e
        }],
        extras: ["acs", function (e) {
            return e && "object" === (void 0 === e ? "undefined" : o(e)) ? JSON.stringify(e) : e
        }]
    }
}, function (e, t, n) {
    "use strict";
    Object.defineProperty(t, "__esModule", {value: !0}), t.default = function () {
        var e = window.yektanetAnalyticsObject || "yektanet", t = window[e] && window[e].q || [],
            o = {product: r.default, user: a.default, event: i.default};
        window[e] = function () {
            var e = arguments[0], t = Object.values(arguments).slice(1), n = o[e];
            if (!n) throw'wrong parameter: "' + e + '"';
            n.apply(this, t)
        }, window[e].product = r.default, window[e].setUser = a.default, window[e].event = i.default;
        for (; 0 < t.length;) try {
            window[e].apply(this || window, Object.values(t.shift()))
        } catch (e) {
        }
    };
    var r = o(n(15)), a = o(n(14)), i = o(n(13));
    function o(e) {
        return e && e.__esModule ? e : {default: e}
    }
}, function (e, t, n) {
    "use strict";
    var o = d(n(6)), r = d(n(5)), a = d(n(12)), i = d(n(10)), u = d(n(7)), c = d(n(3)), f = d(n(16));
    function d(e) {
        return e && e.__esModule ? e : {default: e}
    }
    window.woebegone = {
        analyticsConfig: {
            api_key: "b815be79-a93b-4575-b83f-afd4acfc96ce",
            host_url: "https://ua.yektanet.com/",
            advertiser: {
                enabled: !0,
                id: "1603",
                tags: [{
                    "id": "5e03a360-51be-4db4-94aa-3618c5314c65",
                    "event": {
                        "type": "U", "custom_script": function () {
                            (function () {
                                function getPropertyByName(elem, property) {
                                    if (elem != undefined) return elem.getAttribute(property);
                                }
                                function findProperty(queryList) {
                                    var property = undefined;
                                    for (i = 0, size = queryList.length; i < size && !property; i++) {
                                        var elem = document.querySelector(queryList[i][0]);
                                        property = getPropertyByName(elem, queryList[i][1]);
                                    }
                                    return property;
                                }
                                function extractIntFromText(elem) {
                                    elem = elem.replace(/Û°/g, '0').replace(/Û±/g, '1').replace(/Û²/g, '2').replace(/Û³/g, '3').replace(/Û´/g, '4').replace(/Ûµ/g, '5').replace(/Û¶/g, '6').replace(/Û·/g, '7').replace(/Û¸/g, '8').replace(/Û¹/g, '9').replace(/\D/g, '');
                                    elem = parseInt(elem, 10);
                                    return elem;
                                }
                                var productInfo = {};
                                var skuQueryList = [['input[name="product_id"]', 'value'], ['span[itemprop="sku"]', 'content'], ['meta[itemprop = "productID"]', 'content']];
                                var sku = findProperty(skuQueryList);
                                if (!sku) return false;
                                productInfo.sku = sku;
                                var titleQueryList = [['meta[property="og:title"]', 'content'], ['title', 'text']];
                                productInfo.title = findProperty(titleQueryList);
                                var imageQueryList = [['meta[property="og:image"]', 'content'], ['#product meta[property="og: image"]', 'content'], ['meta[name="twitter:image"]', 'content']];
                                productInfo.image = findProperty(imageQueryList);
                                var priceQueryList = [['#customerPrice', 'value'], ['meta[itemprop="price"]', 'content'], ['meta[property="product:price:amount"]', 'content']];
                                var price = findProperty(priceQueryList);
                                if (price) productInfo.price = Math.round(price);
                                productInfo.currency = "IRT";
                                var oldPriceQueryList = [['#price', 'value']];
                                var oldPrice = findProperty(oldPriceQueryList);
                                var discount = 0;
                                if (oldPrice) {
                                    oldPrice = extractIntFromText(oldPrice);
                                    var discount = (oldPrice - price) / oldPrice * 100;
                                    discount = Math.round(discount);
                                }
                                productInfo.discount = discount;
                                console.log(productInfo);
                                if (productInfo.sku) {
                                    yektanet.product('detail', productInfo);
                                    return true;
                                } else return false;
                            })();
                        }
                    },
                    "patterns": [{"type": "S", "query": "/", "params": {}}]
                }, {
                    "id": "00fab775-9222-4fca-9920-86fb3db0a3d7",
                    "event": {"type": "L"},
                    "patterns": [{"type": "S", "query": "/", "params": {}}]
                }, {
                    "id": "7a1930c1-06af-4125-bff7-e39a27587243",
                    "event": {"type": "L"},
                    "patterns": [{"type": "C", "query": "/landing/3", "params": {}}]
                }, {
                    "id": "2ed0b996-d562-4310-9e24-24ecc22e8858",
                    "event": {"type": "C", "css_selector": ".btn.green.btn-outline"},
                    "patterns": [{"type": "C", "query": "/checkout/payment", "params": {}}]
                }, {
                    "id": "b702e88f-853d-4877-862c-0c76d49dd253",
                    "event": {"type": "L"},
                    "patterns": [{"type": "C", "query": "/product/210", "params": {}}]
                }]
            }
        }, tabToken: (0, c.default)()
    }, (0, o.default)(function () {
        (0, r.default)("aimg"), (0, a.default)(), (0, f.default)(), (0, i.default)(woebegone.analyticsConfig.advertiser.tags), (0, u.default)(!0)
    })
}]);
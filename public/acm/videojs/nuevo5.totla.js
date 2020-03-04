!function (e, t) {
    "object" == typeof exports ? module.exports = t(window, document) : e.SmScroll = t(window, document)
}(this, function (e, t) {
    var s = e.requestAnimationFrame || e.setImmediate || function (e) {
        return setTimeout(e, 0)
    };

    function i(e) {
        Object.prototype.hasOwnProperty.call(e, "data-simple-scrollbar") || Object.defineProperty(e, "data-simple-scrollbar", {value: new a(e)})
    }

    function n(i) {
        for (this.target = i, this.direction = e.getComputedStyle(this.target).direction, this.bar = t.createElement("div"), this.bar.setAttribute("class", "ss-scroll"), this.wrapper = t.createElement("div"), this.wrapper.setAttribute("class", "ss-wrapper"), this.el = t.createElement("div"), this.el.setAttribute("class", "ss-content"), this.el.style.width = i.offsetWidth + 20 + "px", this.wrapper.appendChild(this.el); this.target.firstChild;) this.el.appendChild(this.target.firstChild);
        this.target.appendChild(this.wrapper), this.wrapper.appendChild(this.bar), function (e, i) {
            var n;

            function r(e) {
                var t = e.pageY - n;
                n = e.pageY, s(function () {
                    i.el.scrollTop += t / i.scrollRatio
                })
            }

            function a() {
                e.classList.remove("ss-grabbed"), t.body.classList.remove("ss-grabbed"), t.removeEventListener("mousemove", r), t.removeEventListener("mouseup", a)
            }

            e.addEventListener("mousedown", function (s) {
                return n = s.pageY, e.classList.add("ss-grabbed"), t.body.classList.add("ss-grabbed"), t.addEventListener("mousemove", r), t.addEventListener("mouseup", a), !1
            })
        }(this.bar, this), this.moveBar(), e.addEventListener("resize", this.moveBar.bind(this)), this.el.addEventListener("scroll", this.moveBar.bind(this)), this.el.addEventListener("mouseenter", this.moveBar.bind(this)), this.target.classList.add("ss-container");
        var n = e.getComputedStyle(i);
        "0px" === n.height && "0px" !== n["max-height"] && (i.style.height = n["max-height"])
    }

    function r() {
        for (var e = t.querySelectorAll("*[ss-container]"), s = 0; s < e.length; s++) i(e[s])
    }

    n.prototype = {
        moveBar: function (e) {
            var t = this.el.scrollHeight, i = this.el.clientHeight, n = this;
            this.scrollRatio = i / t, s(function () {
                n.scrollRatio >= 1 ? n.bar.classList.add("ss-hidden") : (n.bar.classList.remove("ss-hidden"), n.bar.style.cssText = "height:" + Math.max(100 * n.scrollRatio, 10) + "%; top:" + n.el.scrollTop / t * 100 + "%;")
            })
        }
    }, t.addEventListener("DOMContentLoaded", r), n.initEl = i, n.initAll = r;
    var a = n;
    return a
}),

videojs.IS_NATIVE_ANDROID && (videojs.options.hls.overrideNative = !0, videojs.options.html5.nativeAudioTracks = !1, videojs.options.html5.nativeTextTracks = !1),
    videojs.options.controlBar = {
    volumePanel: {
        inline: !1,
        vertical: !0
    },
    children: ["playToggle", "liveDisplay", "seekToLive", "currentTimeDisplay", "progressControl", "timeDivider", "durationDisplay", "customControlSpacer", "chaptersButton", "descriptionsButton", "subsCapsButton", "audioTrackButton", "volumePanel", "pictureInPictureToggle", "fullscreenToggle"]
}, videojs.options.techOrder = ["html5"], 1 != videojs.browser.IS_IOS && (videojs.options.hls.overrideNative = !0), videojs.options.html5.nativeAudioTracks = !1, videojs.options.html5.nativeTextTracks = !1;
var e = ["chrome", "party", "treso", "roundal", "pinko", "jwlike", "shaka"];
videojs.options.skinname = "default";
var t = document.createElement("div");
for (var s in document.body.appendChild(t), e) t.className = "vjs-" + e[s], 13 == t.offsetWidth && ("treso" == e[s] ? (videojs.options.skinname = "treso", videojs.options.controlBar = {children: ["progressControl", "playToggle", "liveDisplay", "seekToLive", "currentTimeDisplay", "durationDisplay", "volumePanel", "chaptersButton", "descriptionsButton", "subsCapsButton", "audioTrackButton", "pictureInPictureToggle", "fullscreenToggle"]}) : "chrome" == e[s] ? (videojs.options.skinname = "chrome", videojs.options.controlBar = {children: ["playToggle", "liveDisplay", "seekToLive", "currentTimeDisplay", "timeDivider", "durationDisplay", "customControlSpacer", "progressControl", "volumePanel", "chaptersButton", "descriptionsButton", "subsCapsButton", "audioTrackButton", "pictureInPictureToggle", "fullscreenToggle"]}) : "party" == e[s] ? (videojs.options.skinname = "party", videojs.options.controlBar = {children: ["playToggle", "liveDisplay", "seekToLive", "progressControl", "currentTimeDisplay", "timeDivider", "durationDisplay", "customControlSpacer", "chaptersButton", "descriptionsButton", "subsCapsButton", "audioTrackButton", "volumePanel", "pictureInPictureToggle", "fullscreenToggle"]}) : "roundal" == e[s] ? (videojs.options.skinname = "roundal", videojs.options.controlBar = {
    volumePanel: {
        inline: !1,
        vertical: !0
    },
    children: ["playToggle", "liveDisplay", "seekToLive", "currentTimeDisplay", , "progressControl", "timeDivider", "durationDisplay", "customControlSpacer", "chaptersButton", "descriptionsButton", "subsCapsButton", "audioTrackButton", "volumePanel", "pictureInPictureToggle", "fullscreenToggle"]
}) : "pinko" == e[s] ? (videojs.options.skinname = "pinko", videojs.options.controlBar = {
    volumePanel: {inline: !1, vertical: !0},
    children: ["playToggle", "liveDisplay", "seekToLive", "currentTimeDisplay", "progressControl", "timeDivider", "durationDisplay", "customControlSpacer", "chaptersButton", "descriptionsButton", "subsCapsButton", "audioTrackButton", "volumePanel", "pictureInPictureToggle", "fullscreenToggle"]
}) : "shaka" == e[s] ? (videojs.options.skinname = "shaka", videojs.options.controlBar = {children: ["playToggle", "liveDisplay", "seekToLive", "currentTimeDisplay", "timeDivider", "durationDisplay", "progressControl", "customControlSpacer", "chaptersButton", "descriptionsButton", "subsCapsButton", "audioTrackButton", "volumePanel", "pictureInPictureToggle", "fullscreenToggle"]}) : "jwlike" == e[s] && (videojs.options.skinname = "jwlike", videojs.options.controlBar = {
    volumePanel: {
        inline: !1,
        vertical: !0
    },
    children: ["progressControl", "playToggle", "liveDisplay", "seekToLive", "volumePanel", "customControlSpacer", "currentTimeDisplay", "timeDivider", "durationDisplay", "chaptersButton", "descriptionsButton", "subsCapsButton", "audioTrackButton", "pictureInPictureToggle", "fullscreenToggle"]
}));
document.body.removeChild(t), 1 != videojs.browser.TOUCH_ENABLED ? document.documentElement.className += " no-touch" : document.documentElement.className += " is-touch";
var i = null;

function n(e, t) {
    return e.sort(function (e, s) {
        var i = e[t], n = s[t];
        return i < n ? -1 : i > n ? 1 : 0
    })
}

function r(e, t) {
    try {
        return e.querySelector(t)
    } catch (e) {
        return !1
    }
}

function a(e, t) {
    try {
        return e.querySelectorAll(t)
    } catch (e) {
        return !1
    }
}

function o(e, t) {
    if (e) {
        e.length || (e = [e]);
        for (var s = 0, i = e.length; s < i; s++) null == vjs_hasClass(e[s], t) && (e[s].className += " " + t, e[s].className.replace(/\s+/g, " "))
    }
}

function l(e, t) {
    if (e && (e.classList.remove(t), vjs_hasClass(e, t))) {
        var s = new RegExp("(\\s|^)" + t + "(\\s|$)");
        e.className = e.className.replace(s, " "), e.className.replace(/\s+/g, " ")
    }
}

function d(e) {
    return document.createElement(e)
}

vjs_hasClass = function (e, t) {
    if (e) {
        var s = new RegExp("(\\s|^)" + t + "(\\s|$)");
        return (void 0 === e.className ? window.event.srcElement : e).className.match(s)
    }
}, vjs_inArray = function (e, t) {
    if (t.indexOf) return t.indexOf(e);
    for (var s = 0, i = t.length; s < i; s++) if (t[s] === e) return s;
    return -1
}, function () {
    String.prototype.dg13 = function () {
        return this.replace(/[a-zA-Z]/g, function (e) {
            return String.fromCharCode((e <= "Z" ? 90 : 122) >= (e = e.charCodeAt(0) + 13) ? e : e - 26)
        })
    };
    var e = document.location.hostname.toLowerCase(), t = window.location.hostname.toLowerCase(), s = ["zbp.yrirqbirha", "gfbuynpby", "rupnp"], i = null;
    i = void 0 === window.videojs && "function" == typeof require ? require("video.js") : window.videojs, function (i, c) {
        c = null;
        (c = void 0 === i.videojs && "function" == typeof require ? require("video.js") : i.videojs).registerPlugin("nuevo", function (u) {
            var v = this, h = (this.tech_, new Array), p = c.mergeOptions({
                videoInfo: !1,
                infoSize: 18,
                infoBold: !1,
                infoAlign: "left",
                infoIcon: "",
                infoText: "",
                infoIconURL: "",
                infoFont: "",
                zoomMenu: !0,
                relatedMenu: !0,
                rateMenu: !0,
                shareMenu: !0,
                qualityMenu: !1,
                zoomWheel: !1,
                zoomInfo: !0,
                mirrorButton: !1,
                contextMenu: !0,
                timetooltip: !0,
                mousedisplay: !0,
                errordisplay: !0,
                related: {},
                logo: "",
                logoalpha: 100,
                logocontrolbar: "",
                logoposition: "LT",
                logooffsetX: 10,
                logooffsetY: 10,
                logourl: "",
                shareUrl: "",
                shareTitle: "",
                shareEmebed: "",
                endAction: "",
                pubid: "",
                slideImage: "",
                slideWidth: 192,
                slideHeight: 108,
                slideType: "vertical",
                sharemethod: "auto",
                limit: 0,
                limiturl: "",
                limitimage: "",
                limitmessage: "Watch full video on",
                dashQualities: !0,
                hlsQualities: !0,
                minResolution: 2,
                theaterButton: !1,
                autoplay: !1,
                resume: !0,
                video_id: "",
                playlistNavigation: !1,
                playlistUI: !0,
                playlistShow: !0,
                playlistAutoHide: !0,
                playlist: !1,
                playlistRepeat: !1,
                contextIcon: "",
                contextText: "",
                contextUrl: "",
                res_num: 0,
                target: "_self",
                buttonRewind: !0,
                buttonForward: !1
            }, u), f = v.el(), m = 0, g = 0, j = 0, b = 1;
            f.style.visibility = "visible";
            var A = r(f, ".vjs-big-play-button");
            1 != p.contextMenu && f.addEventListener("contextmenu", function (e) {
                e.preventDefault()
            }, !1), p.related.length > 1 || (p.lang_menu_related = ""), v.autoplay() && (o(A, "vjs-abs-hidden"), o(r(f, ".vjs-loading-spinner"), "vjs-block"));
            var x = "pictureInPictureToggle", k = !0, T = r(f, ".vjs-picture-in-picture-control");
            "undefined" != T && null != T || (k = !1, x = "fullscreenToggle"), !document.pictureInPictureEnabled && k && (o(T, "vjs-hidden"), x = "fullscreenToggle"), quaButton = v.controlBar.addChild("button", {
                el: c.dom.createEl("div", {className: "vjs-quality-button vjs-menu-button vjs-menu-button-popup vjs-control vjs-button vjs-hidden"}, {
                    title: v.localize("Quality"),
                    "aria-haspopup": "true",
                    "aria-expanded": "false"
                })
            }), v.controlBar.el_.insertBefore(quaButton.el_, v.controlBar.getChild(x).el_);
            if (r(f, ".vjs-quality-button").innerHTML = '<button class="vjs-quality-button vjs-menu-button vjs-menu-button-popup vjs-button"><span></span></button><div class="vjs-menu"><ul class="vjs-menu-content vjs-qlist" role="menu"></ul></div>', p.buttonForward) {
                p.buttonRewind && _(!0);
                var w = v.controlBar.addChild("button", {
                    el: c.dom.createEl("button", {className: "vjs-forward-control vjs-control vjs-button"}, {
                        title: v.localize("Forward"),
                        type: "button",
                        "aria-disabled": "false"
                    })
                });

                function I() {
                    v.duration() > 0 && (newdur = v.currentTime() + 10, v.duration() > 0 && (newdur > v.duration() ? v.currentTime(v.duration()) : v.currentTime(newdur)))
                }

                w.el_.innerHTML = '<span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">' + v.localize("Rewind") + "</span>", "party" == c.options.skinname && p.buttonRewind ? v.controlBar.el_.insertBefore(w.el_, r(f, ".vjs-rewind-control").nextSibling) : v.controlBar.el_.insertBefore(w.el_, v.controlBar.getChild("playToggle").el_.nextSibling), w.el_.onclick = function (e) {
                    I()
                }, w.el_.ontouchstart = function (e) {
                    I()
                }
            } else p.buttonRewind && _();

            function _(e) {
                var t = "vjs-rewind-control";
                e && (t = "vjs-rewind-control vjs-rewind-first");
                var s = v.controlBar.addChild("button", {
                    el: c.dom.createEl("button", {className: t + " vjs-control vjs-button"}, {
                        title: v.localize("Rewind"),
                        type: "button",
                        "aria-disabled": "false"
                    })
                });

                function i() {
                    v.duration() > 0 && (newdur = v.currentTime() - 10, newdur < 0 && (newdur = 0), v.currentTime(newdur))
                }

                s.el_.innerHTML = '<span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">' + v.localize("Rewind") + "</span>", e ? "party" == c.options.skinname ? v.controlBar.el_.insertBefore(s.el_, v.controlBar.getChild("playToggle").el_.nextSibling) : v.controlBar.el_.insertBefore(s.el_, v.controlBar.getChild("playToggle").el_) : v.controlBar.el_.insertBefore(s.el_, v.controlBar.getChild("playToggle").el_.nextSibling), s.el_.onclick = function (e) {
                    i()
                }, s.el_.ontouchstart = function (e) {
                    i()
                }
            }

            setButton = v.controlBar.addChild("button", {
                el: c.dom.createEl("div", {className: "vjs-control vjs-button vjs-cog-menu-button vjs-hidden"}, {
                    title: v.localize("Settings"),
                    id: "settings_button",
                    "aria-live": "polite",
                    "aria-disabled": "false"
                })
            }), v.controlBar.el_.insertBefore(setButton.el_, v.controlBar.getChild(x).el_);
            var C = r(f, ".vjs-cog-menu-button");
            p.theaterButton && (theaterBtn = v.controlBar.addChild("button", {
                el: c.dom.createEl("div", {className: "vjs-control vjs-button vjs-control-button vjs-mode-control"}, {
                    title: v.localize("Theater mode"),
                    "aria-live": "polite",
                    "aria-disabled": "false"
                })
            }), v.controlBar.el_.insertBefore(theaterBtn.el_, v.controlBar.getChild("fullscreenToggle").el_), theaterBtn.el_.innerHTML = "<span></span>", theaterBtn.el_.addEventListener(ne("click"), function (e) {
                e.preventDefault(), e.stopPropagation();
                var t = theaterBtn.el_;
                vjs_hasClass(t, "vjs-mode") ? (l(t, "vjs-mode"), v.trigger("mode", "normal")) : (o(t, "vjs-mode"), v.trigger("mode", "large"))
            }, !1));
            var L = d("div");
            L.className = "vjs-menu-settings vjs-hidden";
            var M = d("div");
            M.className = "vjs-menu-div vjs-settings-div", L.appendChild(M);
            var N = d("div");
            N.className = "vjs-submenu vjs-settings-home", M.appendChild(N);
            var z = d("ul");

            function P() {
                try {
                    for (var e = a(f, ".full_quality"), t = a(f, ".item-quality"), s = 0; s < t.length; s++) item = t[s], item2 = e[s], item.ontouchstart = null, item2.ontouchstart = null, item.onclick = null, item2.onclick = null
                } catch (e) {
                }
                try {
                    for (t = a(f, ".vjs-quality-button .vjs-menu .vjs-menu-content li"), s = 0; s < tobin2.length; s++) item = t[s], item.ontouchstart = null, item.onclick = null
                } catch (e) {
                }
                try {
                    var i = r(f, "vjs-back-res .vjs-close-btn");
                    i && (i.onclick = null, i.ontouchstart = null)
                } catch (e) {
                }
                var n = r(f, ".vjs-menu-quality");
                n && n.parentNode.removeChild(n);
                var o = r(f, ".vjs-extend-quality");
                o && o.parentNode.removeChild(o);
                var l = r(f, ".vjs-back-res");
                l && l.parentNode.removeChild(l);
                var d = r(f, ".vjs-menu-quality");
                d && d.parentNode.removeChild(d), r(f, ".vjs-quality-button .vjs-menu .vjs-menu-content").innerHTML = ""
            }

            function H(e) {
                var t = r(f, ".vjs-menu-settings");
                t.removeAttribute("style");
                var s = getComputedStyle(t), i = e + parseInt(s.bottom), n = e + 30;
                1 != vjs_hasClass(t, "vjs-hidden") && parseInt(e) > 0 && (i > f.offsetHeight ? n > f.offsetHeight ? t.style.bottom = "0" : t.style.bottom = "30px" : t.removeAttribute("style"))
            }

            function E(e) {
                r(f, ".vjs-reset-zoom").innerHTML = parseInt(e) + "%", r(f, ".zoom-label").innerHTML = parseInt(e) + "%"
            }

            function B() {
                var e = r(f, ".vjs-menu-settings"), t = r(g = r(f, ".vjs-quality-button"), ".vjs-menu");
                if (m > 1) {
                    var s = function (e) {
                        if (e.preventDefault(), e.stopPropagation(), "none" == t.style.display) {
                            t.style.display = "block";
                            try {
                                var s = r(f, ".vjs-menu-settings");
                                s && o(s, "vjs-hidden")
                            } catch (e) {
                            }
                        } else t.style.display = "none";
                        S()
                    };
                    g.onclick = function (e) {
                        s(e)
                    }, g.ontouchstart = function (e) {
                        s(e)
                    }
                }
                r(f, ".vjs-settings-menu");
                var n = r(f, ".vjs-settings-div"), d = r(f, ".vjs-menu-speed"), c = r(f, ".vjs-zoom-menu"), u = r(f, ".vjs-settings-home"),
                    v = r(f, ".vjs-menu-quality");
                if (d) {
                    var g = r(f, ".vjs-extend-speed"), j = function (e) {
                        e.preventDefault(), e.stopPropagation(), o(u, "vjs-hidden"), l(d, "vjs-hidden"), c && o(c, "vjs-hidden"), v && o(v, "vjs-hidden"), n.style.width = h.speedMenu.width + "px", n.style.height = h.speedMenu.height + "px", H(h.speedMenu.height)
                    };
                    g.onclick = function (e) {
                        j(e)
                    }, g.ontouchstart = function (e) {
                        j(e)
                    };
                    var y = r(d, ".vjs-settings-back");
                    if (y) {
                        var x = function (e) {
                            e.preventDefault(), e.stopPropagation(), o(a(f, ".vjs-submenu"), "vjs-hidden"), l(u, "vjs-hidden"), n.style.width = h.cogMenu.width + "px", n.style.height = h.cogMenu.height + "px", E(100 * b), H(h.cogMenu.height)
                        };
                        y.onclick = function (e) {
                            x(e)
                        }, y.ontouchstart = function (e) {
                            x(e)
                        }
                    }
                }
                if (v) {
                    g = r(f, ".vjs-extend-quality");
                    var k = function (e) {
                        e.preventDefault(), e.stopPropagation(), r(f, ".vjs-qua-list");
                        var t = r(f, ".vjs-menu-settings"), s = i.getComputedStyle(t);
                        parseInt(s.getPropertyValue("bottom")), o(u, "vjs-hidden"), l(v, "vjs-hidden"), d && o(d, "vjs-hidden"), c && o(c, "vjs-hidden"), r(f, ".vjs-qua-list"), n.style.width = h.qualityMenu.width + "px", n.style.height = h.qualityMenu.height + "px", S()
                    };
                    g.onclick = function (e) {
                        k(e)
                    }, g.ontouchstart = function (e) {
                        k(e)
                    };
                    var T = r(v, ".vjs-quality-back");
                    if (T) {
                        var w = function (e) {
                            e.preventDefault(), e.stopPropagation(), o(a(f, ".vjs-submenu"), "vjs-hidden"), l(u, "vjs-hidden"), E(100 * b), n.style.width = h.cogMenu.width + "px", n.style.height = h.cogMenu.height + "px"
                        };
                        T.onclick = function (e) {
                            w(e)
                        }, T.ontouchstart = function (e) {
                            w(e)
                        }
                    }
                }
                if (c) {
                    g = r(f, ".vjs-extend-zoom");
                    var I = function (e) {
                        e.preventDefault(), e.stopPropagation(), o(u, "vjs-hidden"), l(c, "vjs-hidden"), d && o(d, "vjs-hidden"), v && o(v, "vjs-hidden"), n.style.width = h.zoomMenu.width + "px", n.style.height = h.zoomMenu.height + "px";
                        var t = (b - 1) / 4 * 100;
                        r(f, ".vjs-zoom-level").height = t + "%", H(h.zoomMenu.height)
                    };
                    g.onclick = function (e) {
                        I(e)
                    }, g.ontouchstart = function (e) {
                        I(e)
                    };
                    var _ = r(c, ".vjs-settings-back");
                    if (_) {
                        var L = function (e) {
                            e.preventDefault(), e.stopPropagation(), o(a(f, ".vjs-submenu"), "vjs-hidden"), l(u, "vjs-hidden"), n.style.width = h.cogMenu.width + "px", n.style.height = h.cogMenu.height + "px", E(100 * b), H(h.cogMenu.height)
                        };
                        _.onclick = function (e) {
                            L(e)
                        }, _.ontouchstart = function (e) {
                            L(e)
                        }
                    }
                }
                e.onclick = function (e) {
                    e.preventDefault(), e.stopImmediatePropagation()
                }, e.ontouchstart = function (e) {
                    e.preventDefault(), e.stopImmediatePropagation()
                };
                var M = r(f, ".vjs-cog-menu-button"), z = function (t) {
                    t.preventDefault(), t.stopImmediatePropagation(), e.className, vjs_hasClass(e, "vjs-hidden") ? (l(e, "vjs-hidden"), o(A, "vjs-hidden"), o(a(f, ".vjs-submenu"), "vjs-hidden"), l(u, "vjs-hidden"), n.style.width = h.cogMenu.width + "px", n.style.height = h.cogMenu.height + "px", r(r(f, ".vjs-quality-button"), ".vjs-menu").style.display = "none", E(100 * b), H(h.cogMenu.height)) : function () {
                        for (var t = a(f, ".vjs-submenu"), s = 0; s < t.length; s++) o(t[s], "vjs-hidden");
                        l(N, "vjs-hidden"), n.style.width = h.cogMenu.width + "px", n.style.height = h.cogMenu.height + "px", o(e, "vjs-hidden"), l(A, "vjs-hidden")
                    }()
                };
                p.qualityMenu && 1 != p.shareMenu && 1 != p.relatedMenu && 1 != p.zoomMenu && 1 != p.speedMenu && (l(M, "vjs-hidden"), r(f, ".vjs-menu-forward span").style.paddingLeft = "40px"), C.onclick = function (e) {
                    z(e)
                }, C.ontouchstart = function (e) {
                    z(e)
                }
            }

            function D() {
                f.offsetWidth;
                var e = p.related.length;
                if (c.browser.IS_TOUCH_ENABLED) var t = .9; else t = .8;
                if (r(f, ".rel-block")) {
                    l(r(f, ".rel-block"), "rel-anim");
                    var s = f.offsetWidth, i = f.offsetHeight, n = s * t;
                    n > 800 && (n = 800);
                    var a = parseInt(r(f, ".vjs-related").style.maxWidth);
                    isNaN(a) && (a = 0), parseInt(a) < 100 && (a = 800), n > a && (n = a);
                    var d = r(f, ".vjs-related");
                    d.style.maxWidth = "800px", d.style.width = 100 * t + "%";
                    var u = 3, v = 2;
                    e < 5 && 3 != e && (u = 2), e < 4 && (v = 1), n < 480 && (u = 2, v = 1);
                    var h = n / u * .5625, m = n / u, y = Math.ceil(e / 6);
                    g > y && (g = y), j = y, 2 == u && 2 == v && (j = Math.ceil(e / 4)), 2 == u && 1 == v && (j = Math.ceil(e / 2)), d.style.height = h * v + "px";
                    var b = s / 2 - n / 2;
                    if (d.style.top = i / 2 - h * v / 2 + "px", d.style.left = s / 2 - n / 2 + "px", 1 != c.browser.TOUCH_ENABLED) {
                        var A = r(f, ".vjs-arrow-prev"), x = r(f, ".vjs-arrow-next"), k = parseInt(r(f, ".vjs-prev").offsetWidth + 5);
                        A.style.left = b - k + "px", x.style.left = n + b + "px", l(x, "vjs-disabled"), l(A, "vjs-disabled"), g == j && o(x, "vjs-disabled"), 1 == g && o(A, "vjs-disabled")
                    }
                    if (g > 1) {
                        var T = relobj.offsetWidth, w = (g - 1) * T;
                        r(f, ".rel-block").style.left = "-" + w + "px"
                    }
                    for (var I = 0, _ = 0, C = f.querySelectorAll(".rel-parent"), L = 0; L < C.length; L++) {
                        var M = C[L];
                        M.style.left = I + "px", 1 == _ && v > 1 ? (M.style.top = h + "px", I += m) : M.style.top = 0, 1 == v && (I += m), M.style.width = m + "px", M.style.height = h + "px", v > 1 ? 2 == ++_ && (_ = 0) : _ = 0
                    }
                    o(r(f, ".rel-block"), "rel-anim"), 3 == p.newstate && "related" == p.endAction && l(r(f, ".vjs-grid"), "vjs-hidden")
                }
            }

            function S() {
                if (f.offsetHeight < 300) {
                    var e = r(r(f, ".vjs-quality-button"), ".vjs-menu");
                    e && "block" == e.style.display && (l(r(f, ".vjs-back-res"), "vjs-hidden"), e.style.display = "none");
                    var t = r(f, ".vjs-menu-quality");
                    t && -1 == t.className.indexOf("vjs-hidden") && (l(r(f, ".vjs-back-res"), "vjs-hidden"), e.style.display = "none")
                } else o(r(f, ".vjs-back-res"), "vjs-hidden")
            }

            function q() {
                var e = r(f, ".vjs-menu-speed"), t = r(f, ".vjs-zoom-menu"), s = r(f, ".vjs-menu-quality"), i = r(f, ".vjs-settings-div"),
                    n = r(f, ".vjs-control-bar");
                o(n, "vjs-block"), i.style.width = "auto", i.style.height = "auto", e && o(e, "vjs-hidden"), t && o(t, "vjs-hidden"), s && o(s, "vjs-hidden");
                var d = r(f, ".vjs-menu-settings");
                if (l(d, "vjs-hidden"), o(d, "vjs-invisible"), h.cogMenu = {
                    width: d.offsetWidth,
                    height: d.offsetHeight
                }, e && (o(a(f, ".vjs-submenu"), "vjs-hidden"), l(e, "vjs-hidden"), o(e, "vjs-invisible"), h.speedMenu = {
                    width: e.offsetWidth,
                    height: e.offsetHeight
                }, l(e, "vjs-invisible"), o(e, "vjs-hidden")), t && (o(a(f, ".vjs-submenu"), "vjs-hidden"), l(t, "vjs-hidden"), o(t, "vjs-invisible"), h.zoomMenu = {
                    width: t.offsetWidth,
                    height: t.offsetHeight
                }, l(t, "vjs-invisible"), o(t, "vjs-hidden")), s) {
                    o(a(f, ".vjs-submenu"), "vjs-hidden"), l(s, "vjs-hidden"), o(s, "vjs-invisible");
                    var c = d.getBoundingClientRect(), u = (f.getBoundingClientRect().bottom, c.bottom, r(f, ".vjs-qua-list"));
                    h.qualityMenu = {width: s.offsetWidth, height: s.offsetHeight}, o(u, "vjs-2-column"), h.qualityMenu2 = {
                        width: s.offsetWidth,
                        height: s.offsetHeight
                    }, l(u, "vjs-2-column"), l(s, "vjs-invisible"), o(s, "vjs-hidden")
                }
                l(n, "vjs-block"), o(a(f, ".vjs-submenu"), "vjs-hidden"), l(r(f, ".vjs-settings-home"), "vjs-hidden"), i.style.width = h.cogMenu.width + "px", i.style.height = h.cogMenu.height + "px", l(d, "vjs-invisible"), o(d, "vjs-hidden"), l(r(f, ".vjs-settings-home"), "vjs-hidden")
            }

            function O(e, t) {
                var s = parseInt(e), i = "", n = "", a = "HD";
                s > 2159 && (a = "4K"), s > 719 && (n = '<i class="vjs-hd-icon vjs-hd-home">' + a + "</i>", i = '<i class="vjs-hd-icon vjs-hd-menu">' + a + "</i>"), p.qualityMenu ? r(f, ".vjs-extend-quality span").innerHTML = t + i : (r(f, ".vjs-cog-menu-button").innerHTML, r(f, ".vjs-quality-button span").innerHTML = t + n)
            }

            z.className = "vjs-menu-content vjs-settings-list", N.appendChild(z), r(f, ".vjs-control-bar").appendChild(L), i.addEventListener("resize", function (e) {
                D(), S(), q();
                var t = r(f, "vjs-back-res");
                t && o(t, "vjs-hidden"), r(f, "vjs-menu-settings") && o(vjs - menu - p, "vjs-hidden");
                var s = r(f, ".vjs-quality-button");
                if (s) {
                    var i = r(s, ".vjs-menu");
                    i && "block" == i.style.display && (i.style.display = "none")
                }
            }, !1), r(f, "video").controls = !1, "" == p.shareTitle && (p.shareTitle = document.title), "" == p.infoText && (p.infoText = p.shareTitle), 1 != p.errordisplay && o(r(f, ".vjs-error-display"), "vjs-abs-hidden"), 1 != p.timetooltip && o(r(r(f, ".vjs-play-progress"), ".vjs-time-tooltip"), "vjs-abs-hidden");

            function U(e, t) {
                return e.res && t.res ? +t.res - +e.res : 0
            }

            if (1 != p.mousedisplay && o(r(f, ".vjs-mouse-display"), "vjs-abs-hidden vjs-out"), p.logocontrolbar) {
                var W = d("img"), R = !1;
                W.src = p.logocontrolbar, W.onload = function () {
                    if ("naturalHeight" in this ? this.naturalHeight + this.naturalWidth === 0 && (R = !0) : this.width + this.height == 0 && (R = !0), 1 != R) {
                        var e = d("div");
                        if (e.className = "vjs-logo-bar", "" !== p.logourl) {
                            var t = d("a");
                            t.href = p.logourl, t.target = p.target, t.onclick = function (e) {
                                p.waslink = !1
                            }, t.ontouchstart = function (e) {
                                p.waslink = !1
                            }, p.logotitle && t.setAttribute("title", p.logotitle), t.appendChild(W), e.appendChild(t), e.style.cursor = "pointer"
                        } else e.appendChild(K);
                        v.controlBar.el().insertBefore(e, v.controlBar.getChild("fullscreenToggle").el_)
                    }
                }
            }
            if (p.contextMenu) {
                var F = d("div");
                F.className = "vjs-context-menu vjs-hidden";
                var Y = "";

                function Q() {
                    var e;
                    F.innerHTML = Y, v.el().appendChild(F), f.addEventListener("contextmenu", function (t) {
                        clearTimeout(e), t.preventDefault(), l(F, "vjs-hidden");
                        var s = F.offsetWidth, n = F.offsetHeight;
                        if (t.clientY ? cY = t.clientY : cY = null, t.clientX ? cX = t.clientX : cX = null, r(f, ".ctxt").onclick = function (e) {
                            p.waslink = !0
                        }, null !== cY && null !== cX) {
                            var a = f.getBoundingClientRect(), d = cY - a.top, c = cX - a.left;
                            d + n > f.offsetHeight && (d = f.offsetTop + f.offsetHeight - n), c + s > f.offsetWidth && (c = f.offsetWidth - s), F.style.top = d + "px", F.style.left = c + "px", e = setTimeout(function () {
                                o(F, "vjs-hidden")
                            }, 3e3), i.onscroll = function (e) {
                                o(F, "vjs-hidden")
                            }, i.onclick = function (e) {
                                o(F, "vjs-hidden")
                            }
                        }
                    })
                }

                "" == p.contextText ? (p.contextText = "Powewred by Nuevodevel 5.0", p.contextUrl = "https://www.nuevodevel.com/nuevo", Y = '<img src="data:image/gif;base64,R0lGODlhJwASAOZrAPr6+vb29vT09PX19ff39/Ly8ra2tv///+Hh4ebm5tPT09TU1Nzc3Nra2tnZ2dvb2+3t7cHBwX5+fmdnZzc3N0NDQzo6Oq+vr/z8/PDw8GRkZNLS0v39/ZmZmcXFxe7u7srKysjIyPPz83h4eP7+/vj4+Lu7u9/f39HR0XFxcfQAAMQAAHp6euvr6+np6dDQ0GxsbPwAAK0AAHl5eX9/f+fn5/gAAPkAAOIAAIEAALKysjY2Nry8vPHx8Z2dnejo6G5ubvsAAPUAAKIAAPn5+Xt7e7W1tYyMjGtra/oAANYAAGUAAOTk5P0AAOAAAIwAADQAAL0AAD0AAMPDw7GxsW9vb3JycpycnPv7+5qamuXl5U5OTvb396qqqrS0tLe3txQUFJ6enpGRkWVlZaGhoaampkhISJubm42NjXx8fE9PT////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAHoA2sALAAAAAAnABIAAAf/gAABAoSFhoQDh4WJhAEEAZAEBQZrlWsHmJmam5ydnQiWCQoLDKWmpwwNDg2oracPEJgRlhITlre3FBUWuL29FxgZGmsbHAEdvpYeHyCVICHJvSIEI2skmCUm0ScHKJWYKZYqK8kCJSxrHAcYmC3JLgcv3wcwljExKjK95jPpBxsgriWg0atGvHn1KsWwcSMGjhy3zKFTp2MHD3U9fOD6cfDSASD2bIgMImSIJQFEivgzUulID0websGT5xFJyCRClCyJWKKfOpaVWDA5wGGDpaE0MSVc0ySIkydQcPFbiYvbAReVFHRUailIFCm+JFLFNaXEgQFUHGw9UCXarRIDWKyMxXWlwAEsANZmcVsJAgktW+biksAOkzePBTIQ4DJgQInHkPMe6FKJAwYvbhdg4PClMpbPoEODJlCjC5hKYcSM4UumjJlKZ9AcmU279hE0adTw3c3bVyAAOw==" />', Y += "<span>" + p.contextText + "</span>", Y = '<a class="ctxt" target="' + p.target + '" href="' + p.contextUrl + '">' + Y + "</a>", Q()) : "" != p.contextIcon && ((K = d("img")).src = p.contextIcon, K.onload = function () {
                    "naturalHeight" in this ? this.naturalHeight + this.naturalWidth > 0 && (Y = '<img src="' + p.contextIcon + '" />', Y += "<span>" + p.contextText + "</span>", "" != p.contextUrl && (Y = '<a class="ctxt" target="' + p.target + '" href="' + p.contextUrl + '">' + Y + "</a>"), Q()) : this.width + this.height > 0 && (Y = '<img src="' + p.contextIcon + '" />', Y += "<span>" + p.contextText + "</span>", "" != p.contextUrl && (Y = '<a class="ctxt" target="' + p.target + '" href="' + p.contextUrl + '">' + Y + "</a>"), Q()), r(f, ".ctxt").onclick = function (e) {
                        p.waslink = !0
                    }
                }, K.onerror = function () {
                    Y = "<span>" + p.contextText + "</span>", "" != p.contextUrl && (Y = '<a class="ctxt" target="' + p.target + '" href="' + p.contextUrl + '">' + Y + "</a>"), Q()
                })
            }
            if (p.logo) {
                var K;
                (K = d("img")).src = p.logo;
                var X = d("div");
                X.className = "vjs-logo", f.appendChild(X), K.onload = function () {
                    if ("naturalHeight" in this) {
                        if (this.naturalHeight + this.naturalWidth === 0) return void f.removeChild(X)
                    } else if (this.width + this.height == 0) return void f.removeChild(X);
                    var e = p.logooffsetX;
                    if (p.logooffsetY, "RT" == p.logoposition ? (X.style.right = e + "px", X.style.top = e + "px") : (X.style.left = e + "px", X.style.top = e + "px"), "" !== p.logourl) {
                        var t = d("a");
                        t.href = p.logourl, t.target = p.target, p.logotitle && t.setAttribute("title", p.logotitle), t.appendChild(K), X.appendChild(t), t.onclick = function (e) {
                            p.waslink = !1
                        }, t.ontouchstart = function (e) {
                            p.waslink = !1
                        }, X.style.cursor = "pointer"
                    } else X.appendChild(K)
                }, K.onerror = function () {
                    f.removeChild(X)
                }
            }
            if ("treso" == c.options.skinname) {
                var Z = r(f, ".vjs-current-time"), J = r(f, ".vjs-duration"), V = r(f, ".vjs-control-bar");
                V.removeChild(Z);
                var G = r(f, ".vjs-progress-control");
                G.insertBefore(Z, G.childNodes[0]), V.removeChild(J), G.appendChild(J)
            }

            function $() {
                var e = (b - 1) / 4 * 100, t = r(f, ".zoom-thumb");
                t && (t.style.height = e + "%")
            }

            function ee(e, t) {
                if (localStorage) try {
                    localStorage[e] = t
                } catch (e) {
                }
            }

            function te(e, t) {
                $(), e.style.transform = "scale(" + t + ")", e.style.transform = "scale(" + t + ")", e.style.webkitTransform = "scale(" + t + ")", e.style.mozTransform = "scale(" + t + ")", e.style.msTransform = "scale(" + t + ")", e.style.oTransform = "scale(" + t + ")"
            }

            function se() {
                document.body.style.MozUserSelect = "none", document.body.style.webkitUserSelect = "none", document.body.focus(), document.onselectstart = function () {
                    return !1
                }
            }

            function ie() {
                document.body.style.MozUserSelect = "text", document.body.style.webkitUserSelect = "text", document.onselectstart = function () {
                    return !0
                }
            }

            function ne(e) {
                if ("ontouchstart" in document.documentElement) switch (e) {
                    case"click":
                        e = "touchend";
                        break;
                    case"mousedown":
                        e = "touchstart";
                        break;
                    case"mousemove":
                        e = "touchmove";
                        break;
                    case"mouseup":
                        e = "touchend"
                }
                return e
            }

            v.ready(function () {
                p.isAddon = !1, p.newstate = 4, p.oldstate = 4, p.events = {};
                for (var u, f = v.id(), x = v.el(), k = !1, T = v.$(".vjs-tech"), w = this, I = new Array, _ = (new Array, new Array), C = (new Array, c.browser.TOUCH_ENABLED), z = 0; z < s.length; z++) {
                    var H = 1, S = s[z].dg13();
                    // if (S = S.split("").reverse().join(""), e.indexOf(S) > -1 || t.indexOf(S) > -1) {
                    //     H = !0;
                    //     break
                    // }
                }
                if (1 == H) {
                    try {
                        r(x, ".vjs-custom-control-spacer").innerHTML = ""
                    } catch (e) {
                    }
                    v.resetNuevo = function (e) {
                        var t, s = new Array;
                        src = new Array, v.options_.sources.length > 0 && (s = v.options_.sources, src = s), P(), q();
                        try {
                            r(x, ".vjs-quality-button .vjs-menu .vjs-menu-content").innerHTML = "", o(r(x, ".vjs-quality-button"), "vjs-hidden")
                        } catch (e) {
                        }
                        if (s.length > 1) {
                            if (e) {
                                for (var c = v.tech({IWillNotUseThisInPlugins: !0}).el(); c.firstChild;) c.removeChild(c.firstChild);
                                for (var h = 0; h < s.length; h++) if (s[h].src) {
                                    var f = document.createElement("source");
                                    f.setAttribute("src", s[h].src), s[h].type && f.setAttribute("type", s[h].type), s[h].res && f.setAttribute("res", s[h].res), s[h].label && f.setAttribute("label", s[h].label), s[h].default && f.setAttribute("default", !0), c.appendChild(f)
                                }
                            }
                            var g = 0, j = 0;
                            for (g = 0; g < s.length; g++) (s[g].res || s[g].label) && j++;
                            if (j >= p.minResolution) {
                                if (p.dash = !1, p.hls = !1, !v.src) {
                                    var y = !1;
                                    return (p.relatedMenu && related.length > 0 || p.shareMenu || p.rateMenu || p.zoomMenu) && (y = !0), 1 != y && r(x, ".vjs-cog-menu-button").vjs_addClass("vjs-hidden"), v.src()
                                }
                                var b, A = new Array, k = new Array, T = new Array, w = "", C = "", L = 0, M = (h = 0, 0), N = 0, z = 0, H = !1,
                                    E = "MediaSource" in i;
                                for ((t = ["iPad", "iPhone", "iPod"].indexOf(navigator.platform) >= 0) && (E = !1), t && 1 == src.length && (E = !0); L < src.length; L++) {
                                    var D = "";
                                    try {
                                        F = src[L].type
                                    } catch (e) {
                                    }
                                    if ("" != F && (-1 === F.indexOf("mpeg") && -1 === F.indexOf("apple") || (p.hls = !0), -1 !== F.indexOf("dash") && (p.dash = !0)), src[L].res && src[L].label) {
                                        if (1 != H && (H = !0, b = {
                                            res: src[L].res,
                                            type: src[L].type,
                                            src: src[L].src,
                                            label: src[L].label
                                        }), D = src[L].type, src[L].default) var S = "yes"; else S = "";
                                        -1 !== D.indexOf("mpeg") || -1 !== D.indexOf("apple") ? (A[h] = {
                                            res: src[L].res,
                                            label: src[L].label,
                                            type: src[L].type,
                                            src: src[L].src,
                                            default: S
                                        }, ++h > 1 && (p.hls = !0, p.hlsQualities = !1)) : -1 !== D.indexOf("dash") ? (k[M] = {
                                            res: src[L].res,
                                            label: src[L].label,
                                            type: src[L].type,
                                            src: src[L].src,
                                            default: S
                                        }, ++M > 1 && (p.dash = !0, p.dashQualities = !1)) : (T[N] = {
                                            res: src[L].res,
                                            label: src[L].label,
                                            type: src[L].type,
                                            src: src[L].src,
                                            default: S
                                        }, N++)
                                    }
                                }
                                var W = new Array;
                                W = (W = A.length > 0 && E ? A : k.length > 0 && E ? k : T).sort(U);
                                var R = "", Y = " vjs-checked";
                                for (R = ' class="item-quality"', Y = ' class="item-quality vjs-checked"', qcl1 = ' class="quality-full"', qcl2 = ' class="quality-full vjs-checked"', L = 0; L < W.length; L++) {
                                    res = W[L].res, rn = parseInt(res);
                                    var Q = "", K = "HD";
                                    rn > 1079 && (K = "FullHD"), rn > 2159 && (K = "4K"), rn > 719 && (Q = '<i class="vjs-hd-icon">' + K + "</i>"), "yes" == W[L].default ? (def_source = {
                                        res: W[L].res,
                                        type: W[L].type,
                                        src: W[L].src,
                                        label: W[L].label
                                    }, w += "<li" + Y + ' data-res="' + L + '">' + W[L].label + Q + "</li>", C += "<li" + qcl2 + ' data-res="' + L + '">' + W[L].label + Q + "</li>") : (w += "<li" + R + ' data-res="' + L + '">' + W[L].label + Q + "</li>", C += "<li" + qcl1 + ' data-res="' + L + '">' + W[L].label + Q + "</li>"), z++
                                }
                                if (z > 1) {
                                    var X = d("div");
                                    X.className = "vjs-back-res vjs-hidden";
                                    var Z = '<div class="vjs-res-header">' + v.localize("Quality") + '<div class="vjs-close-btn"></div></div>';
                                    X.innerHTML = Z;
                                    var J = d("div");
                                    if (J.className = "vjs-res-block", X.appendChild(J), innUl = d("ul"), J.appendChild(innUl), innUl.innerHTML = C, x.appendChild(X), r(x, ".vjs-back-res .vjs-res-header .vjs-close-btn").onclick = function () {
                                        o(r(x, ".vjs-back-res"), "vjs-hidden")
                                    }, r(x, ".vjs-back-res .vjs-res-header .vjs-close-btn").ontouchstart = function () {
                                        o(r(x, ".vjs-back-res"), "vjs-hidden")
                                    }, m = z, p.res_num = z, p.qualityMenu) {
                                        var V = '<li class="vjs-settings-item vjs-extend-quality vjs-menu-forward">' + v.localize("Quality") + "<span></span></li>",
                                            G = d("div");
                                        G.className = "vjs-submenu vjs-menu-quality vjs-hidden", G.innerHTML = '<ul class="vjs-menu-content"><li class="vjs-settings-back vjs-quality-back">Quality</li></ul><ul class="vjs-menu-content vjs-qua-list">' + w + "</ul>", r(x, ".vjs-settings-list").innerHTML += V, r(x, ".vjs-settings-div").appendChild(G);
                                        var $ = a(x, ".item-quality")
                                    } else r(x, ".vjs-quality-button .vjs-menu .vjs-menu-content").innerHTML = w, l(r(x, ".vjs-quality-button"), "vjs-hidden");
                                    $ = a(x, ".item-quality");
                                    var ee = a(x, ".quality-full");
                                    for (q(), p.menutouch = !1, L = 0; L < $.length; L++) {
                                        var te = $[L], se = ee[L];
                                        te.ontouchstart = function (e) {
                                            p.menutouch = !1
                                        }, te.ontouchmove = function (e) {
                                            p.menutouch = !0
                                        };
                                        var ie = function (e) {
                                            var t;
                                            e.preventDefault(), e.stopPropagation();
                                            for (var s = 0; s < $.length; s++) l($[s], "vjs-checked"), l(ee[s], "vjs-checked"), $[s] != e.target && ee[s] != e.target || (t = s);
                                            o($[t], "vjs-checked"), o(ee[t], "vjs-checked");
                                            var i = e.target.getAttribute("data-res");
                                            O(W[i].res, W[i].label);
                                            var n = {type: W[i].type, src: W[i].src};
                                            v.trigger("resolutionchange", {label: W[i].label, res: W[i].res}), o(r(x, ".vjs-back-res"), "vjs-hidden"), ne(n)
                                        };
                                        se.onclick = function (e) {
                                            ie(e)
                                        }, se.ontouchstart = function (e) {
                                            ie(e)
                                        }, te.onclick = function (e) {
                                            ie(e)
                                        }, te.ontouchstart = function (e) {
                                            ie(e)
                                        }
                                    }

                                    function ne(e) {
                                        var t = v.currentTime(), s = v.paused();
                                        if (e.type, v.src(e), v.load(), v.play(), v.on("loadeddata", function () {
                                            try {
                                                i.URL.revokeObjectURL(mediaurl)
                                            } catch (e) {
                                            }
                                            t > 0 && v.currentTime(t), v.play()
                                        }), v.handleTechSeeked_(), s) {
                                            var n = !0;
                                            v.on("playing", function () {
                                                n && (v.pause(), v.handleTechSeeked_(), n = !1)
                                            })
                                        }
                                    }

                                    (1 != p.hls && 1 != p.dash || 1 != E) && O(b.res, b.label), A.length > 1 && 1 != p.hlsQualities && E && O(b.res, b.label), k.length > 1 && 1 != p.dashQualities && E && O(b.res, b.label), B(), "undefined" != typeof def_source ? (1 != p.hls && 1 != p.dash || 1 != E || A.length > 1 && 1 != p.hlsQualities && E || k.length > 1 && 1 != p.dashQualities && E) && def_source.src != b.src && (O(def_source.res, def_source.label), v.src([{
                                        type: def_source.type,
                                        src: def_source.src
                                    }])) : (A.length > 1 && E || k.length > 1 && E) && O("auto", "Auto")
                                }
                            }
                        }
                        E = "MediaSource" in i, t = ["iPad", "iPhone", "iPod"].indexOf(navigator.platform) >= 0, this.on("loadeddata", function () {
                            var e = new Array;
                            e.length = 0;
                            var s = !1, i = "";
                            if (E && 1 != t) try {
                                v.dash.mediaPlayer.setFastSwitchEnabled(!1);
                                var c = v.dash.mediaPlayer.getBitrateInfoListFor("video"), h = v.dash.mediaPlayer.getQualityFor("video"), f = 0;
                                c.length > 1 && p.dashQualities && (v.dash.mediaPlayer.setAutoSwitchQualityFor("video", !0), c.forEach(function (t) {
                                    var n = new Object;
                                    "video" == t.mediaType && (t.height > 0 || t.bitrate > 0) && (n.id = f, t.height > 0 ? n.height = t.height : n.height = 0, t.bitrate > 0 ? n.bitrate = parseInt(t.bitrate / 1e3) : n.bitrateh = 0, f == h ? (n.auto = 1, s = !0, t.height > 0 && (i = t.height), t.bitrate > 0 && (autores_bitrate = parseInt(t.bitrate / 1e3))) : n.auto = 0, e.push(n), u = "dash"), f += 1
                                }))
                            } catch (e) {
                            }
                            if (E && 1 != t) try {
                                v.tech_.hls.representations().forEach(function (t) {
                                    var n = new Object, r = v.tech_.hls.selectPlaylist();
                                    (t.height > 0 || t.bandwidth > 0) && (n.auto = 0, t.bandwidth && t.bandwidth > 0 && (n.bitrate = parseInt(t.bandwidth / 1e3), r.attributes.BANDWIDTH == t.bandwidth && (n.auto = 1, s = !0, i = t.height, autores_bitrate = t.bandwidth)), n.id = t.id, n.height = t.height, e.push(n), _.push(t.height), u = "hls")
                                })
                            } catch (e) {
                            }
                            e.length > 0 && (P(), m = e.length, I = e, function (e, t, s, i) {
                                if (I.length < 2) P(); else {
                                    for (var c = !0, u = 0, h = 0, f = !1, m = 0, g = I.length; m < g; m++) if (I[m].height > 0 && u++, I[m].bitrate > 0 && h++, I[m].duplicate = !1, I[m].height > 0 && 1 != f) {
                                        var j = 0, y = 0;
                                        for (g = I.length; y < g; y++) I[m].height == I[y].height && j++;
                                        j > 1 && (f = !0)
                                    }
                                    var b = "bitrate";
                                    u > h && (b = "height"), I = (I = n(I, b)).reverse(), R = "item-quality", Y = "item-quality vjs-checked";
                                    var A = "", k = "";
                                    p.res_num = I.length + 1;
                                    var T = d("div");
                                    T.className = "vjs-back-res vjs-hidden";
                                    var w = '<div class="vjs-res-header">' + v.localize("Quality") + '<div class="vjs-close-btn"></div></div>';
                                    T.innerHTML = w;
                                    var _ = d("div");
                                    _.className = "vjs-res-block", T.appendChild(_), innUl = d("ul"), _.appendChild(innUl);
                                    var C = new Array, L = new Array, M = new Array;
                                    for (m = 0, g = I.length; m < g; m++) {
                                        var N = "", z = parseInt(I[m].height), H = "HD";
                                        z > 1079 && (H = "FullHD"), z > 2159 && (H = "4K"), z > 719 && (N = '<i class="vjs-hd-icon">' + H + "</i>");
                                        var E = 0;
                                        if (E = "dash" == e ? I[m].id : I[m].bitrate, I[m].height > 0 || I.bitrate > 0) {
                                            var D = R, S = "full-quality";
                                            if (f) {
                                                var U = I[m].height.toString() + "-" + I[m].bitrate.toString();
                                                I[m].height > 0 && I[m].bitrate > 0 && h == u ? (vjs_inArray(U, M) > -1 && (D = R + " vjs-hidden", S = "full-quality vjs-hidden"), A += '<li class="' + D + '" data-id="' + E + '" data-bit="' + I[m].bitrate + '" data-res="' + I[m].height + '" role="menuitem" aria-live="polite" aria-disabled="false">' + I[m].height + "p <i>(" + I[m].bitrate + " kbps)</i></li>", k += '<li class="' + S + '" data-id="' + E + '" data-bit="' + I[m].bitrate + '" data-res="' + I[m].height + '" role="menuitem" aria-live="polite" aria-disabled="false">' + I[m].height + "p <i>(" + I[m].bitrate + " kbps)</i></li>") : I[m].height > 0 && u > h ? (vjs_inArray(I[m].height, C) > -1 && (D += " vjs-hidden", S += " vjs-hidden"), A += '<li class="' + D + '" data-id="' + E + '" data-bit="' + I[m].bitrate + '" data-res="' + I[m].height + '" role="menuitem" aria-live="polite" aria-disabled="false">' + I[m].height + "p</li>", k += '<li class="' + S + '" data-id="' + E + '" data-bit="' + I[m].bitrate + '" data-res="' + I[m].height + '" role="menuitem" aria-live="polite" aria-disabled="false">' + I[m].height + "p</li>") : (vjs_inArray(I[m].bitrate, L) > -1 && (D += " vjs-hidden", S += " vjs-hidden"), A += '<li class="' + cls11 + '" data-id="' + E + '" data-bit="' + I[m].bitrate + '" data-res="' + I[m].height + '" role="menuitem" aria-live="polite" aria-disabled="false">' + I[m].bitrate + "kbps</li>", k += '<li class="' + S + '" data-id="' + E + '" data-bit="' + I[m].bitrate + '" data-res="' + I[m].height + '" role="menuitem" aria-live="polite" aria-disabled="false">' + I[m].bitrate + "kbps</li>")
                                            } else I[m].bitrate > 0 && h > u ? (vjs_inArray(I[m].bitrate, L) > -1 && (D += " vjs-hidden", S += " vjs-hidden"), A += '<li class="' + D + '" data-id="' + E + '" data-bit="' + I[m].bitrate + '" data-res="' + I[m].height + '" role="menuitem" aria-live="polite" aria-disabled="false">' + I[m].bitrate + " kbps</li>", k += '<li class="' + S + '" data-id="' + E + '" data-bit="' + I[m].bitrate + '" data-res="' + I[m].height + '" role="menuitem" aria-live="polite" aria-disabled="false">' + I[m].bitrate + " kbps</li>") : (vjs_inArray(I[m].height, C) > -1 && (D += " vjs-hidden", S += " vjs-hidden"), A += '<li class="' + D + '" data-id="' + E + '" data-bit="' + I[m].bitrate + '" data-res="' + I[m].height + '" role="menuitem" aria-live="polite" aria-disabled="false">' + I[m].height + "p" + N + "</li>", k += '<li class="' + S + '" data-id="' + E + '" data-bit="' + I[m].bitrate + '" data-res="' + I[m].height + '" role="menuitem" aria-live="polite" aria-disabled="false">' + I[m].height + "p" + N + "</li>")
                                        }
                                        L.push(I[m].bitrate), C.push(I[m].height), levelstring = I[m].height.toString() + "-" + I[m].bitrate.toString(), M.push(levelstring)
                                    }
                                    t && (A += '<li class="item-quality" data-id="Autores" data-res="Autores"' + Y + ' role="menuitem" aria-live="polite" aria-disabled="false">Auto', k += '<li class="full-quality" data-id="Autores_full" data-res="Autores"full-quality vjs-checked role="menuitem" aria-live="polite" aria-disabled="false">Auto', "hls" == e && ("" != s ? (A += '<i class="autores">' + s + "p</i>", k += '<i class="autores2">' + s + "p</i>") : "" != autores_bitate && (A += '<i class=" autores">' + i + "kbps</i>", k += '<i class="autores2">' + i + "kbps</i>")), A += "</li>"), innUl.innerHTML = k, x.appendChild(T);
                                    var W = r(x, ".vjs-back-res .vjs-res-header .vjs-close-btn");
                                    if (W.onclick = function () {
                                        o(r(x, ".vjs-back-res"), "vjs-hidden")
                                    }, W.ontouchstart = function () {
                                        o(r(x, ".vjs-back-res"), "vjs-hidden")
                                    }, p.qualityMenu) {
                                        var F = '<li class="vjs-settings-item vjs-extend-quality vjs-menu-forward">' + v.localize("Quality") + "<span></span></li>",
                                            Q = d("div");
                                        Q.className = "vjs-submenu vjs-menu-quality vjs-hidden", Q.innerHTML = '<ul class="vjs-menu-content"><li class="vjs-settings-back vjs-quality-back">Quality</li></ul><ul class="vjs-menu-content vjs-qua-list">' + A + "</ul>", r(x, ".vjs-settings-list").innerHTML += F, r(x, ".vjs-settings-div").appendChild(Q)
                                    } else r(x, ".vjs-quality-button .vjs-menu .vjs-menu-content").innerHTML = A, l(r(x, ".vjs-quality-button"), "vjs-hidden");
                                    var K = a(x, ".item-quality"), X = a(x, ".full-quality");
                                    for (O("auto", "Auto"), B(), p.menutouch = !1, q(), m = 0; m < K.length; m++) {
                                        te = K[m], se = X[m];
                                        var Z = function (t) {
                                            var s;
                                            t.preventDefault(), t.stopPropagation();
                                            for (var i = K, n = X, a = 0; a < K.length; a++) l(X[a], "vjs-checked"), l(K[a], "vjs-checked"), K[a] == t.target && (s = a), X[a] == t.target && (s = a);
                                            o(i[s], "vjs-checked"), o(n[s], "vjs-checked");
                                            var d = t.target, u = d.getAttribute("data-id"), h = d.getAttribute("data-res"), p = d.getAttribute("data-bit");
                                            if (r(x, ".vjs-quality-button .vjs-menu").style.display = "none", o(r(x, ".vjs-back-res"), "vjs-hidden"), "dash" == e) {
                                                "Autores" == u || "Autores_full" == u ? (v.dash.mediaPlayer.setAutoSwitchQualityFor("video", !0), O("auto", "Auto"), v.trigger("resolutionchange", {
                                                    label: "Auto",
                                                    res: "Auto"
                                                })) : (v.dash.mediaPlayer.setAutoSwitchQualityFor("video", !1), v.dash.mediaPlayer.setQualityFor("video", u), h > 0 ? (O(h, h + "p"), v.trigger("resolutionchange", {
                                                    label: h + "p",
                                                    res: h
                                                })) : p > 0 && (O(h, p + " kbps"), v.trigger("resolutionchange", {label: h + " kB", res: h})));
                                                var f = v.currentTime();
                                                v.currentTime(0);
                                                var m = v.paused();
                                                setTimeout(function () {
                                                    v.currentTime(f), 1 != m && v.play()
                                                }, 100)
                                            } else "Autores" == u || "Autores_full" == u ? (c = !0, v.tech_.hls.representations().forEach(function (e) {
                                                e.enabled(!0)
                                            }), v.tech_.hls.currentLevel = -1, O("auto", "Auto"), v.trigger("resolutionchange", {
                                                label: "Auto",
                                                res: "Auto"
                                            })) : (c = !1, v.tech_.hls.representations().forEach(function (e) {
                                                e.enabled(!1), v.tech_.hls.currentLevel = -1
                                            }), v.tech_.hls.representations().forEach(function (e) {
                                                u == h || parseInt(e.bandwidth / 1e3) == parseInt(u) ? (e.enabled(!0), e.height == h ? O(h, h + "p") : e.bandwidt == p && O(h, parseInt(e.bandwidth / 1e3) + "kbps"), J("Auto"), v.trigger("resolutionchange", {
                                                    label: h + "p",
                                                    res: h
                                                })) : e.enabled(!1)
                                            }))
                                        };

                                        function J(e) {
                                            "Auto" == e && (e = ""), r(x, ".autores").innerHTML = e, r(x, ".autores2").innerHTML = e
                                        }

                                        v.on("mediachange", function () {
                                            if (1 == c) {
                                                if ("hls" == e) {
                                                    var t = v.tech_.hls.selectPlaylist();
                                                    v.tech_.hls.representations().forEach(function (e) {
                                                        if (parseInt(t.attributes.BANDWIDTH) == parseInt(e.bandwidth)) if (e.height > 0) {
                                                            var s = !1, i = "HD", n = parseInt(e.height);
                                                            n > 2159 && (i = "4K"), n > 719 && (s = !0), 1 != p.qualityMenu ? r(x, ".vjs-quality-button span").innerHTML = s ? 'Auto<i class="vjs-hd-icon vjs-hd-home">' + i + "</i>" : "Auto" : r(x, ".vjs-extend-quality span").innerHTML = s ? 'Auto<i class="vjs-hd-icon vjs-hd-menu">' + i + "</i>" : "Auto", J(e.height + "p")
                                                        } else e.bandwith > 0 && J(parseInt(e.bandwidth / 1e3) + "kbps")
                                                    })
                                                }
                                            } else J("Auto")
                                        }), se.className.indexOf("vjs-hidden") < 0 && (se.onclick = function (e) {
                                            Z(e)
                                        }, se.ontouchend = function (e) {
                                            Z(e)
                                        }), te.className.indexOf("vjs-hidden") < 0 && (te.ontouchend = function (e) {
                                            Z(e)
                                        }, te.onclick = function (e) {
                                            Z(e)
                                        })
                                    }
                                }
                            }(u, s, i, ""))
                        }), r(x, ".vjs-mouse-display");
                        var re, ae = r(x, ".vjs-progress-slide");
                        ae && ae.parentNode.removeChild(ae), p.timetooltip && (re = r(r(x, ".vjs-play-progress"), ".vjs-time-tooltip")) && (re.className = "vjs-time-tooltip"), p.mousedisplay && (re = r(x, ".vjs-mouse-display")) && (re.className = "vjs-mouse-display");
                        var oe = r(x, ".vjs-info");
                        if (0 != p.videoInfo && "" != p.infoText) {
                            var le = !1, de = p.shareUrl || document.location.href, ce = d("span");
                            ce.className = "vjs-info", "" != p.infoText ? inner = p.infoText : inner = p.shareTitle;
                            var ue = p.infoSize;
                            parseInt(p.infoSize) > 15 && parseInt(p.infoSize) < 24 && (ue = 18);
                            var ve = "color:#fff;font-size:" + ue + "px;";
                            p.infoBold && (ve += "font-weight:bold;"), "" != p.infoFont ? ve += "font-family:" + p.infoFont : ve += "font-family:sans-serif", ce.style = ve, "" != p.infoIcon && (he = '<img src="' + p.infoIcon + '"/>', "" != p.infoIconURL && (he = '<a target="' + p.target + '" href=' + p.infoIconURL + ">" + he + "</a>", inner = '<a style="' + ve + '" href="' + de + '" target="' + p.target + '">' + inner + "</a>", le = !0), "right" != p.infoAlign ? inner = he + inner : inner += he), 1 != le && (inner = '<a style="' + ve + '" href="' + de + '" target="' + p.target + '">' + inner + "</a>"), ce.innerHTML = inner, oe ? oe.parentNode.replaceChild(ce, oe) : x.appendChild(ce), "right" == p.infoAlign && (ce.style.textAlign = "right");
                            var he = "";
                            ce.onclick = function () {
                                i.open(de, p.target), p.waslink = !0
                            }, ce.ontouchstart = function () {
                                i.open(de, p.target), p.waslink = !0
                            }
                        }
                    };
                    var W = "MediaSource" in i;
                    ["iPad", "iPhone", "iPod"].indexOf(navigator.platform) >= 0 && (W = !1);
                    var R = new Array;
                    if ((R = v.options_.sources).length > 0) {
                        var F = "";
                        try {
                            F = v.options_.sources[0].type
                        } catch (e) {
                        }
                        if (-1 !== F.indexOf("dash") && W) {
                            X = !1;
                            try {
                                X = T.poster
                            } catch (e) {
                            }
                            v.reset(), v.src(R), X && (T.poster = X)
                        }
                        v.resetNuevo(!1)
                    } else v.resetNuevo(!1);
                    v.reconnect = function () {
                        var e = v.src();
                        v.reset(), v.src(e), v.load(), v.resetNuevo(!0), v.play()
                    }, v.changeSource = function (e) {
                        if (e && ("string" == typeof e && (e = {sources: [{src: e}]}), e.src && (e = e.type ? {
                            sources: [{
                                src: e.src,
                                type: e.type
                            }]
                        } : {sources: [{src: e.src}]}), e.sources)) {
                            var t = 1;
                            v.paused() && (t = 2), v.changeSrc(e), 2 == t ? v.pause() : v.play()
                        }
                    }, v.changeSrc = function (e) {
                        if (e && ("string" == typeof e && (e = {sources: [{src: e}]}), e.sources)) {
                            void 0 !== e.slideImage ? p.slideImage = e.slideImage : p.slideImage = "", void 0 !== e.title ? p.infoText = e.title : p.infoText = p.shareTitle, void 0 !== e.url && (p.shareUrl = e.url);
                            var t = "";
                            e.poster ? t = e.poster : v.poster() && (t = v.poster()), v.options_.sources = e.sources, v.reset(), t && v.poster(t), v.src(e.sources), v.load(), v.resetNuevo(!0)
                        }
                    }, v.on("playlistready", function () {
                        p.playlistRepeat && v.playlist.repeat(!0), function () {
                            if (!((f = v.playlist.list()).length < 2)) {
                                if (v.playlist.repeat(), 1 != p.playlist) {
                                    if (p.playlist = !0, p.playlistNavigation) {
                                        var e = d("div");
                                        e.className = "vjs-playlist-nav vjs-nav-prev", e.innerHTML = '<div class="vjs-prev vjs-disabled"></div>';
                                        var t = d("div");
                                        t.className = "vjs-playlist-nav vjs-nav-next", t.innerHTML = '<div class="vjs-next"></div>', x.appendChild(e), x.appendChild(t), t.onclick = function (e) {
                                            e.target.className.indexOf("disabled") < 0 && (v.playlist.nextIndex(), v.playlist.next())
                                        }, t.ontouchstart = function (e) {
                                            e.target.className.indexOf("disabled") < 0 && (v.playlist.nextIndex(), v.playlist.next())
                                        }, e.onclick = function (e) {
                                            e.target.className.indexOf("disabled") < 0 && (v.playlist.previousIndex(), v.playlist.previous())
                                        }, e.ontouchstart = function (e) {
                                            e.target.className.indexOf("disabled") < 0 && (v.playlist.previousIndex(), v.playlist.previous())
                                        }
                                    }
                                    if (p.playlistUI) {
                                        var s = c.dom.createEl("div", {className: "vjs-playlist-button"}, {title: "Playlist"});
                                        x.appendChild(s), s.onclick = function (e) {
                                            o(i, "vjs-vplaylist-show")
                                        }, s.ontouchstart = function (e) {
                                            o(i, "vjs-vplaylist-show")
                                        };
                                        var i = d("div");
                                        i.className = "vjs-vplaylist", p.playlistShow && (i.className = "vjs-vplaylist vjs-vplaylist-show");
                                        var n = d("div");
                                        n.className = "vjs-head", n.innerHTML = "<span>PLAYLIST</span>";
                                        var u = d("div");
                                        u.className = "vjs-back", u.innerHTML = "<i></i>", n.appendChild(u), i.appendChild(n), x.appendChild(i);
                                        var h = d("div");
                                        h.className = "vjs-vlist", i.appendChild(h), u.onclick = function (e) {
                                            l(i, "vjs-vplaylist-show")
                                        }, u.ontouchstart = function (e) {
                                            l(i, "vjs-vplaylist-show")
                                        };
                                        var f = v.playlist.list(), m = 0, g = 0;
                                        for (m = 0; m < f.length; m++) {
                                            var j = d("div");
                                            j.className = "vjs-item", j.setAttribute("data-id", m);
                                            var y = d("div");
                                            y.className = "vjs-tmb", f[m].thumb ? y.style.backgroundImage = "url(" + f[m].thumb + ")" : f[m].poster && (y.style.backgroundImage = "url(" + f[m].poster + ")"), j.appendChild(y);
                                            var b = d("p");
                                            if (f[m].title) b.innerHTML = f[m].title; else {
                                                var A = f[m].sources[0].src, k = A.substring(A.lastIndexOf("/") + 1);
                                                if (f[m].sources.length > 0) for (g = 0; g < f[m].sources.length; g++) if (f[m].sources[g].default) {
                                                    var A = f[m].sources[g].src;
                                                    k = A.substring(A.lastIndexOf("/") + 1)
                                                }
                                                k = k.replace(/(\.[^/.]+)+$/, ""), b.innerHTML = k
                                            }
                                            if (j.appendChild(b), f[m].duration) {
                                                var T = d("span");
                                                T.innerHTML = f[m].duration, j.appendChild(T)
                                            }

                                            function w(e) {
                                                var t = e.target.getAttribute("data-id");
                                                if (v.playlist.currentItem(parseInt(t)), v.paused()) {
                                                    var s = v.play();
                                                    void 0 !== s && "function" == typeof s.then && s.then(null, function (e) {
                                                    })
                                                }
                                            }

                                            for (h.appendChild(j), j.onclick = function (e) {
                                                e.stopPropagation(), w(e)
                                            }; b.offsetHeight > 33;) b.textContent = b.textContent.replace(/\W*\s(\S)*$/, "...")
                                        }
                                        var I = d("div");
                                        I.className = "vjs-last", h.appendChild(I), SmScroll.initEl(h)
                                    }
                                }
                                v.on("playlist_newitem", function (e, t) {
                                    var s = parseInt(t.id) - 1;
                                    if (p.playlistUI) for (var i = a(x, ".vjs-vlist .vjs-item"), n = 0; n < i.length; n++) l(i[n], "vjs-active-item");
                                    v.on("play", function () {
                                        if (p.playlistUI) {
                                            for (var e = a(x, ".vjs-vlist .vjs-item"), t = 0; t < e.length; t++) l(e[t], "vjs-active-item"), e[t].getAttribute("data-id") == s && o(e[t], "vjs-active-item");
                                            if (p.playlistAutoHide) {
                                                var i = r(x, ".vjs-vplaylist");
                                                l(i, "vjs-vplaylist-show")
                                            }
                                        }
                                        if (p.playlistNavigation) {
                                            v.playlist.repeat();
                                            var n = r(x, ".vjs-nav-prev"), d = r(x, ".vjs-nav-next");
                                            0 == v.playlist.currentIndex() ? o(r(n, ".vjs-prev"), "vjs-disabled") : l(r(n, ".vjs-prev"), "vjs-disabled"), v.playlist.currentIndex() == v.playlist.lastIndex() ? o(r(d, ".vjs-next"), "vjs-disabled") : l(r(d, ".vjs-next"), "vjs-disabled")
                                        }
                                    });
                                    try {
                                        if (v.isInPictureInPicture()) {
                                            v.exitPictureInPicture(), document.exitPictureInPicture(), v.isInPictureInPicture(!1);
                                            var d = !1;
                                            v.on("play", function () {
                                                1 != d && (d = !0, v.requestPictureInPicture())
                                            })
                                        }
                                    } catch (e) {
                                    }
                                })
                            }
                        }()
                    }), r(x, ".vjs-tech").ontouchstart = function (e) {
                        V()
                    }, r(x, ".vjs-control-bar").ontouchstart = function (e) {
                    }, i.onclick = function (e) {
                        V()
                    }, i.ontouchstart = function (e) {
                    }, this.pauseLock = !1, p.seeking = !1, r(x, ".vjs-progress-holder").addEventListener("mousedown", function (e) {
                        e.preventDefault(), p.seeking = !0
                    }, !1), r(x, ".vjs-progress-holder").addEventListener("touchstart", function (e) {
                        e.preventDefault(), p.seeking = !0
                    }, {capture: !0, passive: !0}), r(x, ".vjs-progress-holder").addEventListener("touchend", function (e) {
                        e.preventDefault(), p.seeking = !1
                    }, {capture: !0, passive: !0}), r(x, ".vjs-progress-holder").addEventListener("mouseup", function (e) {
                        e.preventDefault(), p.seeking = !1
                    }, {capture: !0, passive: !1}), this.on("timeupdate", function () {
                        if (c.isAd) return !1;
                        if (p.resume && p.video_id) {
                            var e = v.currentTime();
                            (e = e.toFixed(2)) > 0 && ee("vjs_resume", p.video_id + "," + e)
                        }
                    }), this.on("volumechange", function () {
                        ee("volume", v.volume())
                    }), this.on("ended", function () {
                        if (c.isAd) return !1;
                        var e = !0;
                        o(A, "vjs-hidden");
                        var t = r(x, ".vjs-back-res");
                        t && o(t, "vjs-hidden"), p.playlist && (e = !1, v.playlist.currentIndex() == v.playlist.lastIndex() && 1 != v.playlist.repeat && (e = !0)), e && (p.resume && "" != p.video_id && ee("vjs_resume", p.video_id + ",0"), "" != p.endAction ? "share" == p.endAction && p.shareMenu ? (o(r(x, ".vjs-menu-settings"), "vjs-hidden"), l(r(x, ".vjs-sharing-overlay"), "vjs-hidden"), p.isAddon = !0) : "related" == p.endAction && p.relatedMenu && p.related.length > 1 && (l(r(x, ".vjs-grid"), "vjs-abs-hidden"), o(r(x, ".vjs-menu-settings"), "vjs-hidden"), l(r(x, ".vjs-grid"), "vjs-hidden"), D(), p.isAddon = !0) : l(A, "vjs-hidden"))
                    }), this.on("playing", function () {
                        if (v.trigger("firstplay"), c.isAd) return !1;
                        l(A, "vjs-hidden"), A.style.visibility = "visible", l(A, "vjs-abs-hidden"), l(r(x, ".vjs-loading-spinner"), "vjs-block"), C && o(A, "vjs-abs-hidden"), 1 != k && (k = !0)
                    }), this.on("pause", function (e) {
                        (c.browser.IS_ANDROID || c.browser.IS_IOS) && o(A, "vjs-abs-hidden")
                    }), this.volume();
                    var Y = {id: f};
                    try {
                        playerReady(Y)
                    } catch (e) {
                    }
                    v.on("useractive", function () {
                        try {
                            r(x, "video").controls = !1
                        } catch (e) {
                        }
                    }), v.on("userinactive", function () {
                        var e = r(x, ".vjs-menu-settings");
                        e && o(e, "vjs-hidden");
                        var t = r(x, ".vjs-quality-button");
                        if (t) {
                            var s = r(t, ".vjs-menu");
                            s && (s.style.display = "none")
                        }
                    }), v.on("contentupdate", function () {
                        var e = r(x, ".vjs-tech");
                        e.style.top = "0", e.style.left = "0", e.style.transform = "scale(1)", e.style.webkitTransform = "scale(1)", e.style.mozTransform = "scale(1)", e.style.msTransform = "scale(1)", e.style.oTransform = "scale(1)", b = 1
                    }), v.on("firstplay", function () {
                        var e = r(x, ".vjs-mouse-display");
                        if ("" != p.slideImage && 1 != C && e) {
                            var t = r(x, "vjs-progress-slide");
                            t && (t.parentNode, removeChild(t));
                            var s = d("div");
                            s.className = "vjs-progress-slide";
                            var i = d("div"), n = d("div");
                            i.className = "vjs-thumb", n.className = "vjs-thumb-duration";
                            var a = d("img");
                            a.src = p.slideImage, "horizontal" == p.slideType ? (a.style.width = "auto", a.style.height = p.slideHeight + "px") : (a.style.height = "auto", a.style.width = p.slideWidth + "px"), i.appendChild(a), i.appendChild(n), s.appendChild(i), i.style.left = "-" + parseInt(p.slideWidth / 2) + "px", r(x, ".vjs-progress-control").append(s), s.style.left = "-1000px";
                            var l = new Image;
                            l.src = p.slideImage, l.onload = function () {
                                o(r(r(x, ".vjs-play-progress"), ".vjs-time-tooltip"), "vjs-abs-hidden"), o(r(x, ".vjs-mouse-display"), "vjs-abs-hidden");
                                var e = this.width, t = this.height, l = e / p.slideWidth;
                                "horizontal" != p.slideType && (l = t / p.slideHeight), r(x, ".vjs-progress-holder").onmousemove = function (e) {
                                    r(x, ".vjs-progress-slide") && function (e) {
                                        parseInt(v.duration());
                                        var t = r(x, ".vjs-progress-holder").offsetWidth, o = parseFloat(r(x, ".vjs-mouse-display").style.left);
                                        if ("auto" == o) {
                                            var d = parseFloat(r(x, ".vjs-mouse-display").style.left);
                                            o = parseInt(d)
                                        }
                                        var u = Number(o) / Number(t), h = c.options.skinname, f = r(r(x, ".vjs-mouse-display"), ".vjs-time-tooltip").innerHTML;
                                        if ("treso" == c.options.skinname) {
                                            var m = r(x, ".vjs-progress-holder").offsetLeft;
                                            o += m
                                        }
                                        var g = parseInt(u * l);
                                        if (r(x, ".vjs-thumb").style.width = p.slideWidth + "px", r(x, ".vjs-thumb").style.height = p.slideHeight + "px", "horizontal" == p.slideType) {
                                            var j = g * p.slideWidth;
                                            a.style.left = "-" + j + "px"
                                        } else j = g * p.slideHeight, a.style.top = "-" + j + "px";
                                        o < 0 && (o = 0), o > t && (o = t), n.innerHTML = f;
                                        var y = p.slideWidth / 2;
                                        "treso" == h && (y += m);
                                        var b = t - p.slideWidth / 2;
                                        "treso" == h && (b += m), o < y && (o = y), o > b && (o = b), "party" == h && (o += 10), s.style.left = o + "px", i.style.opacity = 1, i.style.MozOpacity = 1, i.style.filter = "alpha(opacity=100)"
                                    }()
                                }, r(x, ".vjs-progress-holder").onmouseout = function (e) {
                                    r(x, ".vjs-progress-slide") && (i.style.opacity = 0, i.style.MozOpacity = 0, i.style.filter = "alpha(opacity=0)", s.style.left = "-1000px")
                                }
                            }
                        }
                        if (p.resume && "" != p.video_id) {
                            if (localStorage && localStorage.vjs_resume) {
                                var u = localStorage.vjs_resume.split(",");
                                2 == u.length && u[0] == p.video_id && Number(u[1]) > 3 && (u[1], v.currentTime(u[1]))
                            }
                            ee("vjs_resume", p.video_id + ",0")
                        }
                        try {
                            r(x, "video").controls = !1
                        } catch (e) {
                        }
                        if (p.limit > 0 && ("" != p.limiturl || "" != p.shareUrl)) {
                            var h = !1;
                            v.on("timeupdate", function () {
                                if (v.currentTime() > p.limit && (v.pause(), A.style.display = "none", 1 != h)) {
                                    h = !0;
                                    var e = d("div");
                                    e.className = "vjs-limit-overlay";
                                    var t = d("a");
                                    if (t.className = "vjs-limit", t.href = p.limiturl, t.target = p.target, t.style.textDecoration = "none", e.appendChild(t), t.onclick = function (e) {
                                        p.waslink = !0
                                    }, t.ontouchstart = function (e) {
                                        p.waslink = !0
                                    }, "" == p.limiturl && (p.limiturl = p.shareUrl), "" != p.limitimage) {
                                        var s = d("img");
                                        s.src = p.limitimage, s.onload = function () {
                                            t.innerHTML = '<img style="max-width:100%;height:auto;" src="' + p.limitimage + '" />'
                                        }, s.onerror = function () {
                                            i()
                                        }
                                    } else i();

                                    function i() {
                                        var e = d("span");
                                        e.style.lineHeight = "1.5em";
                                        var s = p.limitmessage;
                                        e.innerHTML = s + '<span style="color:#fff;">' + p.limiturl + "</span>", t.appendChild(e)
                                    }

                                    v.el().appendChild(e)
                                }
                            })
                        }
                        k || (v.$(".vjs-tech"), v.$(".vjs-tech"))
                    });
                    var Q = !1;
                    if ((p.relatedMenu || p.shareMenu || p.rateMenu || p.zoomMenu) && (Q = !0), Q && (k = !1, v.on("firstplay", function () {
                        if (!k) {
                            k = !0, localStorage && localStorage.volume && v.volume(localStorage.volume);
                            var e = "", t = !1, s = !1;
                            p.shareMenu && (e = e + '<li class="vjs-settings-item vjs-share-button">' + v.localize("Share") + '<span class="vjs-share-icon"></span></li>'), p.relatedMenu && p.related.length > 1 && (e = e + '<li class="vjs-settings-item vjs-related-button">' + v.localize("Related") + '<span class="vjs-related-icon"></span></li>'), p.zoomMenu && (e = e + '<li class="vjs-settings-item vjs-extend-zoom vjs-menu-forward">' + v.localize("Zoom") + '<span class="zoom-label">100%</span></li>', (s = d("div")).className = "vjs-submenu vjs-zoom-menu vjs-hidden", s.innerHTML = '<div class="vjs-settings-back vjs-zoom-return"><span>' + v.localize("Zoom") + '</span></div><div class="vjs-zoom-slider"><div class="vjs-zoom-back"></div><div class="vjs-zoom-level"></div></div><div class="vjs-zoom-reset">RESET</div>'), p.rateMenu && (e = e + '<li class="vjs-settings-item vjs-extend-speed vjs-menu-forward">' + v.localize("Speed") + "<span>Normal</span></li>", (t = d("div")).className = "vjs-submenu vjs-menu-speed vjs-hidden", t.innerHTML = '<ul class="vjs-menu-content"><li class="vjs-settings-back">' + v.localize("Speed") + '</li><li class="vjs-speed">0.5x</li><li class="vjs-speed vjs-checked">1x</li><li class="vjs-speed">1.5x</li><li class="vjs-speed">2x</li></ul>');
                            var n = r(x, ".vjs-settings-list");
                            if ("" != e) {
                                e += "", n.innerHTML = e + n.innerHTML, t && r(x, ".vjs-settings-div").appendChild(t), s && r(x, ".vjs-settings-div").appendChild(s), l(r(x, ".vjs-cog-menu-button"), "vjs-hidden"), B(), q();
                                for (var u = function (e) {
                                    e.preventDefault(), e.stopImmediatePropagation();
                                    var t = e.target.innerHTML, s = (t = t.replace("x", "")) + "x";
                                    if ("1" == t && (s = "Normal"), r(x, ".vjs-extend-speed span").innerHTML = s, parseFloat(t) > 0) {
                                        v.playbackRate(t);
                                        for (var i = x.querySelectorAll(".vjs-speed"), n = 0; n < i.length; n++) l(i[n], "vjs-checked");
                                        o(this, "vjs-checked")
                                    }
                                }, h = x.querySelectorAll(".vjs-speed"), f = 0; f < h.length; f++) h[f].addEventListener("click", u, !0), h[f].addEventListener("touchstart", u, !0)
                            }
                            if (p.related.length > 1 && p.relatedMenu) {
                                var m = p.related.length, T = d("div"), I = !1;
                                c.browser.TOUCH_ENABLED && (I = !0), relHTML = '<div class="vjs-close-btn"></div>', 1 != I && (relHTML += '<div class="vjs-arrow vjs-arrow-prev vjs-disabled"><div class="vjs-prev"></div></div><div class="vjs-arrow vjs-arrow-next"><div class="vjs-next"></div></div>'), T.innerHTML = relHTML, T.className = "vjs-grid vjs-hidden";
                                var _ = d("p");
                                _.innerHTML = v.localize("Related videos");
                                var L = d("div");
                                L.className = "vjs-related", I && (L.className = "vjs-related vjs-scroll");
                                var M = x.offsetWidth, N = .8 * M;
                                if (I && (N = .9 * M), T.appendChild(_), T.appendChild(L), x.appendChild(T), 1 != I) {
                                    var z = parseInt(r(x, ".vjs-prev").offsetWidth) + 5;
                                    r(x, ".vjs-arrow-prev").style.left = parseInt(L.style.left) - z + "px", r(x, ".vjs-arrow-next").style.left = N + parseInt(L.style.left) + "px"
                                }
                                var P = d("div");
                                P.className = "rel-block rel-anim", L.appendChild(P);
                                var H = p.related;
                                for (g = 1, f = 0; f < m; f++) {
                                    var S = d("div");
                                    S.className = "rel-parent";
                                    var O = d("div");
                                    O.className = "rel-item", S.appendChild(O), P.appendChild(S), O.innerHTML = '<a class="rel-url" target="' + p.target + '" href="' + H[f].url + '" alt="' + H[f].title + '"><span class="rel-bg" style="background-image:url(' + H[f].thumb + ');"></span><label>' + H[f].title + "</label><i>" + H[f].duration + "</i></a>"
                                }
                                var U = a(x, ".rel-url");
                                for (f = 0; f < U.length; f++) U[f].onclick = function (e) {
                                    p.waslink = !0
                                };
                                m < 7 && 1 != I && (o(r(x, ".vjs-arrow-next"), "vjs-hidden"), o(r(x, ".vjs-arrow-prev"), "vjs-hidden"));
                                var W = function (e) {
                                    if (e.preventDefault(), e.stopImmediatePropagation(), !vjs_hasClass(r(x, ".vjs-arrow-next"), "vjs-disabled")) {
                                        var t = r(x, ".vjs-related").offsetWidth;
                                        g++, l(r(x, ".vjs-arrow-prev"), "vjs-disabled");
                                        var s = (g - 1) * t;
                                        r(x, ".rel-block").style.left = "-" + s + "px", g == j && o(r(x, ".vjs-arrow-next"), "vjs-disabled"), 1 == g && o(r(x, ".vjs-arrow-next"), "vjs-disabled")
                                    }
                                };
                                1 != I && (r(x, ".vjs-arrow-next").onclick = function (e) {
                                    W(e)
                                }, r(x, ".vjs-arrow-next").onctouchstart = function (e) {
                                    W(e)
                                });
                                var R = function (e) {
                                    if (e.preventDefault(), e.stopImmediatePropagation(), !vjs_hasClass(r(x, ".vjs-arrow-prev"), "vjs-disabled")) {
                                        var t = r(x, ".vjs-related").offsetWidth, s = ((g -= 1) - 1) * t;
                                        r(x, ".rel-block").style.left = "-" + s + "px", 1 != I && (1 == g && o(r(x, ".vjs-arrow-prev"), "vjs-disabled"), l(r(x, ".vjs-arrow-next"), "vjs-disabled"))
                                    }
                                };
                                1 != I && (r(x, ".vjs-arrow-prev").onclick = function (e) {
                                    R(e)
                                }, r(x, ".vjs-arrow-prev").onctouchstart = function (e) {
                                    R(e)
                                }), r(x, ".vjs-related-button").addEventListener(ne("click"), function (e) {
                                    e.preventDefault(), e.stopImmediatePropagation(), p.waslink = !1, o(r(x, ".vjs-menu-settings"), "vjs-hidden"), o(A, "vjs-hidden"), l(r(x, ".vjs-grid"), "vjs-hidden"), D(), p.isAddon = !0, player_state = v.paused(), p.player_state = player_state, 1 != player_state && v.pause()
                                }, !1), r(r(x, ".vjs-grid"), ".vjs-close-btn").addEventListener("click", function (e) {
                                    e.preventDefault(), p.isAddon = !1, o(r(x, ".vjs-grid"), "vjs-hidden"), 1 != p.player_state && v.play()
                                })
                            }
                            if (p.shareMenu) {
                                var F = d("div");
                                F.className = "vjs-sharing-overlay vjs-hidden";
                                var Y = d("div");
                                Y.className = "vjs-sharing-container";
                                var Q = d("div");
                                Q.className = "vjs-sharing-body";
                                var K = p.shareUrl || document.location.href, X = p.shareEmbed || "N/A", Z = d("div");
                                Z.className = "vjs-close-btn vjs-share-close";
                                var J = (J = '<div class="vjs-inputs-body"><h2>' + v.localize("Link") + '</h2><input type="text" class="perma"><h2>' + v.localize("Embed") + '</h2><input class="embed-code" type="text"></div>') + '<div class="vjs-inputs-body"><h2>' + v.localize("Social") + "</h2></div>";
                                if (J += '<div class="vjs-share-block"><i title="Dacebook" id="share_facebook" class="vjs-share-icon nv vjs-facebook-square" role="button" aria-live="polite" tabindex="0"></i>', J += '<i title="Twitter" id="share_twitter" class="vjs-share-icon nv vjs-twitter-square" role="button" aria-live="polite" tabindex="0"></i>', J += '<i title="Pinterest" id="share_pinterest" class="vjs-share-icon nv vjs-pinterest-square" role="button" aria-live="polite" tabindex="0"></i>', J += '<i title="LinkedIn" id="share_linkedin" class="vjs-share-icon nv vjs-linkedin-square" role="button" aria-live="polite" tabindex="0"></i></div>', Q.innerHTML = J, Y.appendChild(Q), F.appendChild(Z), F.appendChild(Y), v.el().appendChild(F), r(x, ".embed-code").value = X, r(x, ".perma").value = K, r(x, ".vjs-share-button").addEventListener(ne("click"), function (e) {
                                    e.preventDefault(), e.stopImmediatePropagation(), o(r(x, ".vjs-menu-settings"), "vjs-hidden"), l(F, "vjs-hidden"), w.pauseLock = !0, o(A, "vjs-hidden"), p.isAddon = !0;
                                    var t = v.paused();
                                    p.player_state = t, 1 != t && v.pause()
                                }, !1), "auto" == p.sharemethod) var V = {
                                    url: K,
                                    title: p.shareTitle || document.title,
                                    description: v.localize("Check out this cool video on") + " " + p.shareUrl
                                }; else V = {
                                    url: K,
                                    title: p.shareTitle || document.title,
                                    description: v.localize("Check out this cool video on") + " " + p.shareUrl,
                                    pubid: p.pubid || null
                                };
                                var ee = function (e) {
                                    e.preventDefault(), e.stopImmediatePropagation();
                                    var t = "";
                                    switch (e.target.id.split("_")[1]) {
                                        case"facebook":
                                            t = "facebook";
                                            break;
                                        case"twitter":
                                            t = "twitter";
                                            break;
                                        case"pinterest":
                                            t = "pinterest";
                                            break;
                                        case"linkedin":
                                            t = "linkedin"
                                    }
                                    i.open("http://api.addthis.com/oexchange/0.8/forward/" + t + "/offer?" + function (e) {
                                        var t = [];
                                        for (var s in e) t.push(encodeURIComponent(s) + "=" + encodeURIComponent(e[s]));
                                        return t.join("&")
                                    }(V), "AddThis", "height=450,width=550,modal=yes,alwaysRaised=yes")
                                }, ae = x.querySelectorAll(".vjs-share-icon");
                                for (f = 0; f < ae.length; f++) ae[f].addEventListener("click", ee, !1);

                                function oe() {
                                    p.isAddon = !1, o(r(x, ".vjs-sharing-overlay"), "vjs-hidden"), o(A, "vjs-hidden"), p.isAddon = !1, w.pauseLock = !1, 1 == p.player_state && 3 != p.newstate || v.play()
                                }

                                r(x, ".vjs-inputs-body").onclick = function (e) {
                                    e.preventDefault(), e.stopImmediatePropagation()
                                }, r(x, ".vjs-inputs-body input").onclick = function (e) {
                                    this.select()
                                }, r(x, ".vjs-share-close").onclick = function (e) {
                                    oe()
                                }, r(x, ".vjs-share-close").ontouchstart = function (e) {
                                    oe()
                                }
                            }
                            if (p.zoomMenu) {
                                var le = r(x, ".vjs-poster");
                                if (le.setAttribute("style", ""), le.style.display = "inline-block", c.browser.TOUCH_ENABLED && (r(x, ".vjs-tech").style.pointerEvents = "none"), p.zoomInfo) {
                                    var de = d("div");
                                    de.className = "vjs-zoom-parent vjs-hidden";
                                    var ce = d("div");
                                    ce.className = "vjs-reset-zoom", ce.innerHTML = v.localize("100%"), de.appendChild(ce), this.zf = d("div"), this.zf.className = "vjs-reset-center", this.zf2 = d("div"), this.zf2.className = "vjs-reset-cancel", de.appendChild(this.zf), de.appendChild(this.zf2), this.zf3 = d("div"), this.zf3.className = "vjs-reset-info", de.appendChild(this.zf3);
                                    var ue = d("div");

                                    function ve(e) {
                                        e.preventDefault(), e.stopPropagation(), vjs_hasClass(ue, "vjs-hidden") ? (l(ue, "vjs-hidden"), o(A, "vjs-hidden")) : (o(ue, "vjs-hidden"), l(A, "vjs-hidden"))
                                    }

                                    function he() {
                                        o(ue, "vjs-hidden"), l(A, "vjs-hidden")
                                    }

                                    ue.className = "vjs-zoom-help vjs-hidden", p.zoomWheel ? ue.innerHTML = '<div class="zoom-close">x</div><div>' + v.localize("ZOOM HELP") + "</div>" + v.localize("Use ZOOM slider or mouse wheel to ZOOM in video.") + "<div>" + v.localize("Drag zoomed area using your mouse or a finger.") + "</div>" : ue.innerHTML = '<div class="zoom-close">x</div><div>' + v.localize("ZOOM HELP") + "</div>" + v.localize("Drag zoomed area using your mouse and move it to new position.") + "</div>", de.appendChild(this.zf3), this.zf3.addEventListener("mouseup", ve, !1), this.zf3.addEventListener("touchend", ve, !1), r(ue, ".zoom-close").addEventListener("mouseup", he, !1), r(ue, ".zoom-close").addEventListener("touchend", he, !1), x.appendChild(ue), this.zf2.addEventListener("mouseup", re, !1), this.zf2.addEventListener("touchend", re, !1), this.zf.addEventListener("mouseup", G, !1), this.zf.addEventListener("touchend", G, !1), x.appendChild(de)
                                }
                                r(x, ".vjs-zoom-reset").addEventListener("mouseup", re, !1), r(x, ".vjs-zoom-reset").addEventListener("touchend", re, !1);
                                var pe = v.el();
                                if (pe.hasAttribute("tabIndex") || pe.setAttribute("tabIndex", "-1"), pe.style.outline = "none", p.zoomWheel) {
                                    if (c.browser.TOUCH_ENABLED) {
                                        var fe = d("div");
                                        fe.className = "vjs-zoom-slide";
                                        var me = d("div");
                                        me.className = "zoom-bg";
                                        var ge = d("div");
                                        ge.className = "zoom-thumb", fe.appendChild(me), fe.appendChild(ge), x.appendChild(fe), fe.style.height = x.offsetHeight - 85 + "px", i.addEventListener("resize", function (e) {
                                            fe.style.height = x.offsetHeight - 85 + "px", $()
                                        }, !1), pum = !1, fe.addEventListener("touchstart", function (e) {
                                            e.preventDefault(), e.stopPropagation(), se(), o(fe, "vjs-slide-block");
                                            var t = function (e) {
                                                e.preventDefault(), e.stopPropagation(), xe(e, fe)
                                            }, s = function (e) {
                                                e.preventDefault(), e.stopPropagation(), ie(), setTimeout(function () {
                                                    l(fe, "vjs-slide-block")
                                                }, 3e3), document.removeEventListener(ne("touchend"), s), document.removeEventListener(ne("touchmove"), t)
                                            };
                                            document.addEventListener("touchmove", t, !1), document.addEventListener("touchend", s, !1)
                                        }, !1)
                                    }

                                    function je(e) {
                                        e.preventDefault(), e.stopPropagation();
                                        var t = 20 * Math.max(-1, Math.min(1, e.wheelDelta || -e.detail)), s = r(x, ".vjs-tech");
                                        (b = (100 * b + t) / 100) < 1 && (b = 1), b > 5 && (b = 5), 1 == b ? (re(), o(r(x, ".vjs-zoom-parent"), "vjs-hidden"), l(A, "vjs-hidden")) : (l(r(x, ".vjs-zoom-parent"), "vjs-hidden"), te(s, b), o(A, "vjs-hidden"));
                                        var i = r(x, ".vjs-zoom-menu");
                                        if (1 != vjs_hasClass(i, "vjs-hidden")) {
                                            var n = (b - 1) / 4 * 100;
                                            r(x, ".vjs-zoom-level").style.height = n + "%", E(100 * b)
                                        }
                                        return !1
                                    }

                                    le.addEventListener("mousewheel", je, !1), le.addEventListener("DOMMouseScroll", je, !1)
                                }

                                function ye(e) {
                                    if (b > 1) {
                                        e.preventDefault(), e.stopPropagation(), isDown = !0;
                                        var t = r(x, ".vjs-tech");
                                        try {
                                            offset = [t.offsetLeft - e.clientX, t.offsetTop - e.clientY]
                                        } catch (e) {
                                        }
                                        try {
                                            offset = [t.offsetLeft - e.touches[0].clientX, t.offsetTop - e.touches[0].clientY]
                                        } catch (e) {
                                        }
                                        document.addEventListener("mouseup", Ae, !0), document.addEventListener("mousemove", be, !0), document.addEventListener("touchend", Ae, !0), document.addEventListener("touchmove", be, !0)
                                    }
                                }

                                function be(e) {
                                    if (e.preventDefault(), isDown) {
                                        try {
                                            mousePosition = {x: event.clientX, y: event.clientY}
                                        } catch (e) {
                                        }
                                        try {
                                            mousePosition = {x: event.touches[0].clientX, y: event.touches[0].clientY}
                                        } catch (e) {
                                        }
                                        var t = r(x, ".vjs-tech"), s = mousePosition.x + offset[0], i = mousePosition.y + offset[1],
                                            n = x.offsetWidth / 2 * (b - 1), a = x.offsetHeight / 2 * (b - 1);
                                        s > n && (s = n), s < -1 * n && (s = -1 * n), i > a && (i = a), i < -1 * a && (i = -1 * a), t.style.left = s + "px", t.style.top = i + "px"
                                    }
                                }

                                function Ae(e) {
                                    e.preventDefault(), isDown = !1, document.removeEventListener("mouseup", Ae), document.removeEventListener("mousemove", be), document.removeEventListener("touchend", Ae), document.removeEventListener("touchmove", be)
                                }

                                function xe(e, t) {
                                    var s = !1;
                                    if (c.browser.TOUCH_ENABLED) {
                                        try {
                                            s = e.originalEvent.touches[0].pageY
                                        } catch (e) {
                                        }
                                        try {
                                            s = e.originalEvent.changedTouches[0].pageY
                                        } catch (e) {
                                        }
                                        try {
                                            s = e.changedTouches[0].pageY
                                        } catch (e) {
                                        }
                                    } else try {
                                        s = e.pageY
                                    } catch (e) {
                                    }
                                    if (0 != s) {
                                        var i = t.offsetHeight, n = s - function (e) {
                                            for (var t = e.offsetTop; e = e.offsetParent;) t += e.offsetTop;
                                            return t
                                        }(t);
                                        n > i && (y = i), n < 0 && (n = 0);
                                        var a = parseInt(100 - n / i * 100);
                                        a < 0 && (a = 0), a > 100 && (a = 100);
                                        try {
                                            r(x, ".vjs-zoom-level").style.height = a + "%"
                                        } catch (e) {
                                        }
                                        try {
                                            r(x, ".zoom-thumb").style.height = a + "%"
                                        } catch (e) {
                                        }
                                        var d = 1 + 4 * a / 100;
                                        b = d, v.id(), te(r(x, ".vjs-tech"), d), E(100 * d), d > 1 ? (c.options.blockKeys = !0, l(r(x, ".vjs-zoom-parent"), "vjs-hidden"), o(A, "vjs-hidden")) : (re(), c.options.blockKeys = !1, o(r(x, ".vjs-zoom-parent"), "vjs-hidden"), l(A, "vjs-hidden"))
                                    }
                                }

                                le.addEventListener("mousedown", ye, !0), le.addEventListener("touchstart", ye, !0), r(x, ".vjs-zoom-slider").addEventListener("click", function (e) {
                                    e.preventDefault(), e.stopPropagation(), e.stopImmediatePropagation()
                                }, !1), r(x, ".vjs-zoom-slider").addEventListener(ne("mousedown"), function (e) {
                                    e.preventDefault(), e.stopImmediatePropagation(), se();
                                    var t = r(x, ".vjs-zoom-slider");
                                    xe(e, t), 1 != C && l(r(x, ".vjs-zoom-info"), "vjs-hidden");
                                    var s = function (e) {
                                        e.preventDefault(), e.stopPropagation(), xe(e, t)
                                    }, i = function (e) {
                                        e.preventDefault(), e.stopPropagation(), ie(), document.removeEventListener(ne("mouseup"), i), document.removeEventListener(ne("mousemove"), s)
                                    };
                                    document.addEventListener(ne("mousemove"), s, !1), document.addEventListener(ne("mouseup"), i, !1)
                                }, !1)
                            }
                        }
                    })), 0 != p.mirrorButton) {
                        v.controlBar.mirrorButton = v.controlBar.addChild("button", {
                            el: c.dom.createEl("div", {
                                text: "Mirror view",
                                className: "vjs-mirror-button vjs-control vjs-button"
                            }, {title: v.localize("Mirror view"), role: "button", "aria-live": "polite", "aria-disabled": "false"})
                        }), v.controlBar.el_.insertBefore(v.controlBar.mirrorButton.el_, v.controlBar.getChildById("settings_button").el_);
                        var K = function (e) {
                            e.preventDefault();
                            var t = x.className, s = !1;
                            t.indexOf("vjs-has-started") > 0 && (s = !0);
                            var i, n = !1;
                            t.indexOf("vjs-ended") > 0 && (n = !0), s && 1 != n && (vjs_hasClass(e.target, "vjs-mirrored") ? (l(e.target, "vjs-mirrored"), (i = r(x, ".vjs-tech")).style.transform = "rotateY(0)", i.style.transform, i.style.webkitTransform = "rotateY(0)", i.style.mozTransform = "rotateY(0)", i.style.msTransform = "rotateY(0)", i.style.oTransform = "rotateY(0)") : (o(e.target, "vjs-mirrored"), (i = r(x, ".vjs-tech")).style.transform = "rotateY(180deg)", i.style.transform, i.style.webkitTransform = "rotateY(180deg)", i.style.mozTransform = "rotateY(180deg)", i.style.msTransform = "rotateY(180deg)", i.style.oTransform = "rotateY(180deg)"))
                        };
                        r(x, ".vjs-mirror-button").onclick = function (e) {
                            K(e)
                        }, r(x, ".vjs-mirror-button").ontouchstart = function (e) {
                            K(e)
                        }
                    }
                    v.trigger("nuevoReady")
                } else {
                    var X = T.getAttribute("poster"), Z = d("div");
                    if (Z.className = "vjs-lcn", Z.innerHTML = "deretsiger ton tcudorP".split("").reverse().join(""), X) {
                        var J = d("img");
                        J.className = "vjs-lcn-poster", J.src = X, p.shareTitle && J.setAttribute("alt", p.shareTitle), x.innerHTML = "", x.appendChild(J)
                    }
                    x.appendChild(Z)
                }

                function V(e) {
                    p.isAddon && (p.isAddon = !1, o(r(x, ".vjs-grid"), "vjs-hidden"), o(r(x, ".vjs-sharing-overlay"), "vjs-hidden"), l(A, "vjs-hidden"), p.isAddon = !1, w.pauseLock = !1, 1 != p.waslink ? 1 == p.player_state && 3 != p.newstate || v.play() : (v.pause(), p.waslink = !1));
                    for (var t = a(x, ".vjs-submenu"), s = 0; s < t.length; s++) o(t[s], "vjs-hidden");
                    l(N, "vjs-hidden");
                    try {
                        M.style.width = h.cogMenu.width + "px", M.style.height = h.cogMenu.height + "px"
                    } catch (e) {
                    }
                    o(L, "vjs-hidden"), r(x, ".vjs-quality-button .vjs-menu").style.display = "none", r(x, ".vjs-menu").style.display = "none"
                }

                function G(e) {
                    try {
                        e.preventDefault(), e.stopPropagation()
                    } catch (e) {
                    }
                    var t = r(x, ".vjs-tech");
                    t.style.left = t.offsetWidth / 2 - x.offsetWidth / 2 + "px", t.style.top = t.offsetHeight / 2 - x.offsetHeight / 2 + "px"
                }

                function re(e) {
                    $(), b = 1, l(A, "vjs-hidden");
                    try {
                        r(x, ".vjs-zoom-level").style.height = "0"
                    } catch (e) {
                    }
                    var t = r(x, ".vjs-tech");
                    te(t, 1), t.style.top = 0, t.style.left = 0, r(x, ".vjs-menu-settings"), r(x, "vjs-vjs-settings-home"), E(100);
                    var s = r(x, ".vjs-zoom-parent");
                    return 1 != vjs_hasClass(s, "vjs-hidden") && o(s, "vjs-hidden"), c.options.blockKeys = !1, !1
                }
            })
        })
    }(window, i)
}(), function (e, t) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = t(require("video.js")) : "function" == typeof define && define.amd ? define(["video.js"], t) : (e = e || self).videojsPlaylist = t(e.videojs)
}(this, function (e) {
    "use strict";
    e = e && e.hasOwnProperty("default") ? e.default : e;
    var t = !1, s = function (e) {
        var t = e.playlist.autoadvance_;
        t.timeout && e.clearTimeout(t.timeout), t.trigger && e.off("ended", t.trigger), t.timeout = null, t.trigger = null
    }, i = function e(t, i) {
        var n;
        (s(t), "number" == typeof (n = i) && !isNaN(n) && n >= 0 && n < 1 / 0) ? (t.playlist.autoadvance_.delay = i, t.playlist.autoadvance_.trigger = function () {
            var n = function () {
                return e(t, i)
            };
            t.one("play", n), t.playlist.autoadvance_.timeout = t.setTimeout(function () {
                s(t), t.off("play", n), t.playlist.next()
            }, 1e3 * i)
        }, t.one("ended", t.playlist.autoadvance_.trigger)) : t.playlist.autoadvance_.delay = null
    }, n = function (e, s) {
        var n = !e.paused() || e.ended();
        return e.trigger("beforeplaylistitem", s.originalValue || s), s.playlistItemId_ && (e.playlist.currentPlaylistItemId_ = s.playlistItemId_), e.changeSrc(s), 1 != t ? t = !0 : e.trigger("playlist_change"), function (e) {
            for (var t = e.remoteTextTracks(), s = t && t.length || 0; s--;) e.removeRemoteTextTrack(t[s])
        }(e), e.ready(function () {
            if ((s.textTracks || []).forEach(e.addRemoteTextTrack.bind(e)), e.trigger("playlistitem", s.originalValue || s), e.trigger("playlist_newitem", {id: s.playlistItemId_}), n) {
                var t = e.play();
                void 0 !== t && "function" == typeof t.then && t.then(null, function (e) {
                })
            }
            i(e, e.playlist.autoadvance_.delay)
        }), e
    }, r = function (e) {
        return !!e && "object" == typeof e
    }, a = function (e) {
        var t, s = [];
        return e.forEach(function (e) {
            r(e) ? t = e : (t = Object(e)).originalValue = e, s.push(t)
        }), s
    }, o = function (e) {
        var t = 1;
        e.forEach(function (e) {
            e.playlistItemId_ = t++
        })
    }, l = function (e, t) {
        for (var s = 0; s < e.length; s++) if (e[s].playlistItemId_ === t) return s;
        return -1
    }, d = function (e, t) {
        for (var s = 0; s < e.length; s++) {
            var i = e[s].sources;
            if (Array.isArray(i)) for (var n = 0; n < i.length; n++) {
                var r = i[n];
                if (r && (l = void 0, d = void 0, l = a = r, d = o = t, "object" == typeof a && (l = a.src), "object" == typeof o && (d = o.src), /^\/\//.test(l) && (d = d.slice(d.indexOf("//"))), /^\/\//.test(d) && (l = l.slice(l.indexOf("//"))), l === d)) return s
            }
        }
        var a, o, l, d;
        return -1
    };
    var c = function (t, c) {
        player.ready(function () {
            !function (t, c, u) {
                void 0 === u && (u = 0);
                var v = null, h = !1, p = t.playlist = function (e, s) {
                    if (void 0 === s && (s = 0), h) throw new Error("do not call playlist() during a playlist change");
                    if (Array.isArray(e)) {
                        var i = Array.isArray(v) ? v.slice() : null, n = e.slice();
                        (v = n.slice()).filter(function (e) {
                            return r(e)
                        }).length !== v.length && (v = a(v)), o(v), h = !0, t.trigger({
                            type: "duringplaylistchange",
                            nextIndex: s,
                            nextPlaylist: n,
                            previousIndex: p.currentIndex_,
                            previousPlaylist: i || []
                        }), h = !1, -1 !== s && p.currentItem(s), i && t.setTimeout(function () {
                            t.trigger("playlistchange")
                        }, 0)
                    }
                    return v.map(function (e) {
                        return e.originalValue || e
                    }).slice()
                };
                t.on("loadstart", function () {
                    -1 === p.currentItem() && s(t)
                }), p.currentIndex_ = -1, p.player_ = t, p.autoadvance_ = {}, p.repeat_ = !1, p.currentPlaylistItemId_ = null, p.currentItem = function (e) {
                    if (h) return p.currentIndex_;
                    if ("number" == typeof e && p.currentIndex_ !== e && e >= 0 && e < v.length) return p.currentIndex_ = e, n(p.player_, v[p.currentIndex_]), p.currentIndex_;
                    var t = p.player_.currentSrc() || "";
                    if (p.currentPlaylistItemId_) {
                        var s = l(v, p.currentPlaylistItemId_), i = v[s];
                        if (i && Array.isArray(i.sources) && d([i], t) > -1) return p.currentIndex_ = s, p.currentIndex_;
                        p.currentPlaylistItemId_ = null
                    }
                    return p.currentIndex_ = p.indexOf(t), p.currentIndex_
                }, p.contains = function (e) {
                    return -1 !== p.indexOf(e)
                }, p.indexOf = function (e) {
                    if ("string" == typeof e) return d(v, e);
                    for (var t = Array.isArray(e) ? e : e.sources, s = 0; s < t.length; s++) {
                        var i = t[s];
                        if ("string" == typeof i) return d(v, i);
                        if (i.src) return d(v, i.src)
                    }
                    return -1
                }, p.currentIndex = function () {
                    return p.currentItem()
                }, p.lastIndex = function () {
                    return v.length - 1
                }, p.nextIndex = function () {
                    var e = p.currentItem();
                    if (-1 === e) return -1;
                    var t = p.lastIndex();
                    return p.repeat_ && e === t ? 0 : Math.min(e + 1, t)
                }, p.previousIndex = function () {
                    var e = p.currentItem();
                    return -1 === e ? -1 : p.repeat_ && 0 === e ? p.lastIndex() : Math.max(e - 1, 0)
                }, p.first = function () {
                    if (!h) {
                        var e = p.currentItem(0);
                        if (v.length) return v[e].originalValue || v[e];
                        p.currentIndex_ = -1
                    }
                }, p.last = function () {
                    if (!h) {
                        var e = p.currentItem(p.lastIndex());
                        if (v.length) return v[e].originalValue || v[e];
                        p.currentIndex_ = -1
                    }
                }, p.next = function () {
                    if (!h) {
                        var e = p.nextIndex();
                        if (e !== p.currentIndex_) {
                            var t = p.currentItem(e);
                            return v[t].originalValue || v[t]
                        }
                    }
                }, p.previous = function () {
                    if (!h) {
                        var e = p.previousIndex();
                        if (e !== p.currentIndex_) {
                            var t = p.currentItem(e);
                            return v[t].originalValue || v[t]
                        }
                    }
                }, p.autoadvance = function (e) {
                    i(p.player_, e)
                }, p.repeat = function (t) {
                    return void 0 === t ? p.repeat_ : "boolean" == typeof t ? (p.repeat_ = !!t, p.repeat_) : void e.log.error("videojs-playlist: Invalid value for repeat", t)
                }, p.list = function () {
                    return v
                }, p.sort = function (e) {
                    v.length && (v.sort(e), h || t.trigger("playlistsorted"))
                }, Array.isArray(c) ? p(c.slice(), u) : v = []
            }(this, t, c), player.playlist.autoadvance(0), player.trigger("playlistready")
        })
    };
    return (e.registerPlugin || e.plugin)("playlist", c), c
}), function (e, t) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = t(require("video.js")) : "function" == typeof define && define.amd ? define(["video.js"], t) : (e = e || self).videojsMidroll = t(e.videojs)
}(this, function (e) {
    "use strict";

    function t(t, s) {
        var a, c, u, v, h, p, f, m, g = new Array, j = !1, y = !1, b = new Array, A = !1, x = !1, k = !1, T = 0, w = 0, I = 0, _ = !1, C = !1, L = !1, M = !1,
            N = !1, z = (new Array, t.$(".vjs-tech"));
        if (e.isAd = !1, e.browser.IS_IOS && (C = !0), e.ignoreIOS && (C = !1), !Array.isArray(s)) {
            var P = s;
            if (P.src && P.href && P.offset && P.src.length > 5 && P.href.length > 5) {
                var H = 0;
                try {
                    H = g[E].offset.indexOf("%")
                } catch (e) {
                }
                H > 0 && x || ((s = new Array)[0] = P)
            }
        }
        if (Array.isArray(s)) for (var E = 0; E < s.length; E++) {
            var B = s[E];
            if (B.src && B.href && B.offset && B.src.length > 5 && B.href.length > 5 && parseInt(B.offset) >= 0) {
                B.loaded = !1;
                H = 0;
                try {
                    H = g[E].offset.indexOf("%")
                } catch (e) {
                }
                H > 0 && x || g.push(B)
            }
        }
        t.ready(function () {
            if (g.length > 0) {
                if (C) {
                    (u = d("a")).className = "roll-blocker vjs-hidden", u.target = "_blank", (p = d("div")).className = "vjs-roll-controls vjs-hidden";
                    var s = '<div class="roll-btn roll-play-pause roll-paused"></div><div class="roll-countdown">' + t.localize("Advertisement") + '</div><div class="roll-btn roll-fscreen roll-non-fullscreen"></div>';
                    s += '<div class="roll-btn roll-mute roll-non-muted"></div>', p.innerHTML = s, t.el_.appendChild(u), t.el_.appendChild(p), v = t
                } else {
                    (a = d("div")).className = "vjs-roll vjs-hidden", (c = d("video")).preload = "Auto", c.setAttribute("playsinline", "true"), c.setAttribute("webkit-playsinline", "true"), (u = d("a")).className = "roll-blocker", u.target = "_blank", (p = d("div")).className = "vjs-roll-controls";
                    s = '<div class="roll-btn roll-play-pause roll-paused"></div><div class="roll-countdown">' + t.localize("Advertisement") + '</div><div class="roll-btn roll-fscreen roll-non-fullscreen"></div>';
                    s += '<div class="roll-btn roll-mute roll-non-muted"></div>', p.innerHTML = s, a.appendChild(c), a.appendChild(u), a.appendChild(p), t.el_.appendChild(a), v = c
                }
                t.on("loadeddata", function () {
                    if (t.el_.className.indexOf("vjs-live") > -1 && (x = !0), t.duration() === 1 / 0 && (x = !0), "8" === e.browser.IOS_VERSION && 0 === t.duration() && (x = !0), !x) var s = t.duration();
                    if (g.length > 0 && 1 != _) {
                        _ = !0;
                        for (var P = 0; P < g.length; P++) {
                            if (!x) {
                                var H = 0;
                                try {
                                    H = g[P].offset.indexOf("%")
                                } catch (e) {
                                }
                                if (H > 0) {
                                    var E = parseInt(g[P].offset);
                                    g[P].offset = 100 == E ? s : s * (E / 100)
                                }
                            }
                            g[P].offset = g[P].offset
                        }
                    }

                    function B(e) {
                        var t = {source: e.src()};
                        e.textTracks && e.textTracks();
                        return t
                    }

                    function D(t) {
                        var s = void 0;
                        e.browser.IS_IOS && x ? s = t.seekable().length > 0 ? t.currentTime() - t.seekable().end(0) : t.currentTime() : 1 != x && (s = t.currentTime());
                        var i = !1;
                        1 != x && (i = t.ended());
                        for (var n = t.textTracks ? t.textTracks() : [], r = [], a = {
                            ended: i,
                            currentSrc: t.currentSrc(),
                            src: t.src(),
                            currentTime: s,
                            type: t.currentType()
                        }, o = 0; o < n.length; o++) {
                            var l = n[o];
                            r.push({track: l, mode: l.mode}), l.mode = "disabled"
                        }
                        return a.suppressedTracks = r, a
                    }

                    if (g.length > 1 && (g = n(g, "offset")), g.length > 0) {
                        function S() {
                            j ? (clearTimeout(T), N = !1) : (q(w += .5), T = setTimeout(S, 500))
                        }

                        function q(s) {
                            if (!(t.isFullscreen() && e.browser.IS_IOS && e.ignoreIOS)) for (var i = s, n = t.duration(), d = 0; d < g.length; d++) {
                                var v = g[d];
                                if (C) {
                                    if (i >= v.offset && v.offset <= n && 1 != A && 1 != g[d].loaded) {
                                        t.pause(), g[d].loaded = !0, f = g[d], clearTimeout(T), N = !1, m = x ? B(t) : D(t);
                                        var y = {src: v.src, type: v.type};

                                        function k() {
                                            j = !0, t.off("playing", k)
                                        }

                                        t.src(y), o(r(t.el_, ".vjs-control-bar"), "vjs-hidden"), "" != v.href ? (u.href = v.href, u.className = "roll-blocker") : u.className = "roll-blocker vjs-hidden", p.className = "vjs-roll-controls", t.play(), A = !0, t.on("playing", k);
                                        try {
                                            t._el.removeChild(h)
                                        } catch (e) {
                                        }
                                        (I = f.skip > 0 ? parseInt(f.skip) : 0) > 0 && Y()
                                    }
                                } else if (i >= v.offset && v.offset <= n && 1 != v.loaded && (1 != v.loaded && 1 != A ? (A = !0, g[d].loaded = !0, c.src = v.src, c.type = v.type, c.load(), f = v, u.href = v.href) : 1 != v.loaded && (g[d].loaded = !0, b.push(v))), f && 1 != j && i >= f.offset && f.offset <= n) {
                                    j = !0, A = !0;
                                    try {
                                        a.removeChild(h)
                                    } catch (e) {
                                    }
                                    y = {src: f.src, type: f.type};
                                    I = f.skip > 0 ? parseInt(f.skip) : 0, l(a, "vjs-hidden"), "" != f.href && (u.className = "roll-blocker"), t.pause(), O(), I > 0 && Y()
                                }
                            }
                        }

                        x ? t.on("playing", function () {
                            1 != k && (k = !0, T = setTimeout(S, 500), N = !0)
                        }) : t.on("timeupdate", function () {
                            q(t.currentTime())
                        }), x && (t.on("pause", function (e) {
                            clearTimeout(T), N = !1
                        }), t.on("playing", function (e) {
                            1 != A && g.length > 0 && 1 != N && (N = !0, T = setTimeout(S, 500))
                        })), g.length > 0 && (0 != g[0].offset && "0" != g[0].offset || C || (A = !0, j = !0, clearTimeout(T), N = !1, g[0].loaded = !0, c.src = g[0].src, c.type = g[0].type, c.load(), f = g[0], u.href = g[0].href, t.on("playing", function () {
                            if (1 != M) {
                                M = !0, j = !0;
                                var e = r(t.el_, ".vjs-poster");
                                z.poster = "", e.className = "vjs-poster vjs-hidden", clearTimeout(T), N = !1, 1 != y && (f.id && t.trigger("vroll", {
                                    id: f.id,
                                    action: "play"
                                }), y = !0);
                                try {
                                    a.removeChild(h)
                                } catch (e) {
                                }
                                I = f.skip > 0 ? parseInt(f.skip) : 0, l(a, "vjs-hidden"), t.paused() || (t.pause(), O(), I > 0 && Y())
                            }
                        })));

                        function O() {
                            t.pause(), clearTimeout(T), N = !1, 0;
                            var s = c.play();
                            void 0 !== s && s.then(function () {
                            }).catch(function (e) {
                                var t = r(p, ".roll-mute");
                                o(t, "roll-muted"), l(t, "roll-non-muted"), c.volume = 0, c.muted = !0, c.play()
                            }), e.isAd = !0
                        }

                        u.onclick = function () {
                            u.className = "roll-blocker vjs-hidden", null != f.id && t.trigger("midroll", {id: f.id, action: "click"})
                        }, u.ontouchstart = function () {
                            u.className = "roll-blocker vjs-hidden", null != f.id && t.trigger("midroll", {id: f.id, action: "click"})
                        };
                        var U = function () {
                            return v == c ? v.paused : v.paused()
                        }, W = function () {
                            return v == c ? v.muted : t.muted()
                        };

                        function R() {
                            if (1 == j) {
                                try {
                                    a.removeChild(h)
                                } catch (e) {
                                }
                                try {
                                    t.el_.removeChild(h)
                                } catch (e) {
                                }
                                if (!1, y = !1, f = void 0, 1 != C) {
                                    v.pause();
                                    try {
                                        c.removeAttribute("src")
                                    } catch (e) {
                                    }
                                    if (b.length > 0) {
                                        A = !0, j = !0, f = b[0];
                                        for (var s = 0; s < g.length; s++) b.src == g[s].src && (g[s].loaded = !0, g[s].done = !0);
                                        c.src = f.src, c.type = f.type, u.href = f.href, f.skip > 0 ? (I = parseInt(f.skip), Y()) : I = 0, b.shift(), t.pause(), O(), I > 0 && Y()
                                    } else A = !1, j = !1, c.pause(), l(r(t.el_, ".vjs-control-bar"), "vjs-hidden"), a.className = "vjs-roll vjs-hidden", e.isAd = !1, t.ended() ? (r(t.el_, ".vjs-loading-spinner").style.display = "none", t.trigger("ended")) : t.play()
                                } else {
                                    var i = !1;
                                    if (o(r(t.el_, ".vjs-poster"), "vjs-hidden"), g.length > 0 && g.shift(), g.length > 0 && g[0].offset <= m.currentTime) {
                                        0, A = !0, j = !0, g[0].loaded = !0, e.isAd = !0;
                                        var n = {src: (f = g[0]).src, type: f.type};
                                        t.src(n), t.load(), o(r(t.el_, ".vjs-control-bar"), "vjs-hidden"), "" != f.href ? (u.href = f.href, u.className = "roll-blocker") : u.className = "roll-blocker vjs-hidden", p.className = "vjs-roll-controls", t.play();
                                        try {
                                            t._el.removeChild(h)
                                        } catch (e) {
                                        }
                                        (I = f.skip > 0 ? parseInt(f.skip) : 0) > 0 && Y(), i = !0
                                    }
                                    if (1 != i) A = !1, j = !1, u.className = "roll-blocker vjs-hidden", l(r(t.el_, ".vjs-control-bar"), "vjs-hidden"), p.className = "vjs-roll-controls vjs-hidden", o(r(t.el_, ".vjs-poster"), "vjs-hidden"), r(t.el_, ".vjs-loading-spinner").style.display = "block", z.poster = "", x ? (t.src(m.source), t.play()) : (!function (t, s, i) {
                                        void 0 === i && (i = function () {
                                        });
                                        var n, a = s.suppressedTracks, o = void 0, l = function (e) {
                                            t.currentTime(s.currentTime), t.play(), t.off("loadeddata", l)
                                        };
                                        z.poster = "", "style" in s && z.setAttribute("style", s.style || ""), t.src({
                                            src: s.currentSrc,
                                            type: s.type
                                        }), t.load(), n = void 0, C && x ? s.currentTime < 0 && (n = t.seekable().length > 0 ? t.seekable().end(0) + s.currentTime : t.currentTime(), t.currentTime(n)) : s.ended ? (r(t.el_, ".vjs-loading-spinner").style.display = "none", e.isAd = !1, t.trigger("ended")) : C ? (t.on("loadeddata", l), t.play()) : (t.currentTime(s.currentTime), t.play()), function () {
                                            for (var e = 0; e < a.length; e++) (o = a[e]).track.mode = o.mode
                                        }(), i()
                                    }(t, m), e.isAd = !1), e.isAd = !1
                                }
                            }
                        }

                        function F(e, s) {
                            var i = s - (e = e > 0 ? e : 0), n = Math.floor(i / 60), a = Math.floor(i % 60);
                            if ((a.toString().length < 2 && (a = "0" + a), !isNaN(n) && !isNaN(a)) && (r(p, ".roll-countdown").innerHTML = t.localize("Advertisement") + "<span>" + n + ":" + a + "</span>", I > 0)) {
                                var o = Math.ceil(I - e), l = "";
                                if (o > 0) if (1 != L) L = !0, l += "<span>" + t.localize("Skip Ad in") + ' <i id="time_left">' + o + "</i></span>", h.innerHTML = l; else try {
                                    document.getElementById("time_left").innerHTML = o
                                } catch (e) {
                                } else L && "roll-skip-button enabled" != h.className && (h.innerHTML = "<span>" + t.localize("Skip Now!") + '</span><i class="circle"></i>', h.className = "roll-skip-button enabled")
                            }
                        }

                        function Y() {
                            try {
                                a.removeChild(h)
                            } catch (e) {
                            }
                            try {
                                i.removeChild(h)
                            } catch (e) {
                            }

                            function e(e) {
                                e.stopPropagation(), (" " + h.className + " ").indexOf(" enabled ") >= 0 && (f.id && t.trigger("vroll", {
                                    id: f.id,
                                    action: "skip"
                                }), R())
                            }

                            (h = d("div")).className = "roll-skip-button", L = !1, C ? t.el_.appendChild(h) : a.appendChild(h), h.onclick = function (t) {
                                e(t)
                            }, h.ontouchstart = function (t) {
                                e(t)
                            }
                        }

                        function Q() {
                            U() ? (v.play(), l(this, "roll-playing"), o(this, "roll-paused")) : (v.pause(), l(this, "roll-paused"), o(this, "roll-playing"))
                        }

                        function K() {
                            W() ? (v == c ? v.muted = !1 : v.muted(!1), o(this, "roll-non-muted"), l(this, "roll-muted")) : (v == c ? v.muted = !0 : v.muted(!0), o(this, "roll-muted"), l(this, "roll-non-muted"))
                        }

                        C ? (v.on("ended", function () {
                            A && R()
                        }), v.on("error", function () {
                            A && adTime > 0 && R()
                        }), v.on("timeupdate", function () {
                            if (A && !U()) {
                                if (v == c && v.pause(), v == c) var e = v.duration; else e = v.duration();
                                if (v == c) var s = c.currentTime; else (s = v.currentTime()) > 0 && l(t.$(".vjs-tech"), "vjs-hidden");
                                F(s, e)
                            }
                        }), v.on("playing", function () {
                            r(t.el_, ".vjs-loading-spinner").style.display = "none", A && (event.preventDefault(), clearTimeout(T), N = !1, 1 != y && (f.id && t.trigger("vroll", {
                                id: f.id,
                                action: "play"
                            }), y = !0))
                        })) : (v.onended = function () {
                            A && R()
                        }, v.onerror = function () {
                            A && R()
                        }, v.ontimeupdate = function () {
                            if (A && !U()) {
                                t.pause();
                                var e = v.duration;
                                F(c.currentTime, e)
                            }
                        }, v.onplaying = function () {
                            A && (clearTimeout(T), N = !1, 1 != y && (f.id && t.trigger("vroll", {id: f.id, action: "play"}), y = !0))
                        }), r(p, ".roll-play-pause").onclick = function (e) {
                            Q()
                        }, r(p, ".roll-play-pause").ontouchstart = function (e) {
                            Q()
                        }, r(p, ".roll-mute").onclick = function (e) {
                            K()
                        }, r(p, ".roll-mute").ontouchstart = function (e) {
                            K()
                        };
                        var X = r(p, ".roll-fscreen");

                        function Z() {
                            if (t.isFullscreen()) t.exitFullscreen(); else {
                                if (e.browser.IS_IOS && e.ignoreIOS && j) return;
                                t.requestFullscreen()
                            }
                        }

                        X.onclick = function (e) {
                            Z()
                        }, X.ontouchstart = function (e) {
                            Z()
                        }, t.on("fullscreenchange", function () {
                            t.isFullscreen() ? (o(X, "roll-fullscreen"), l(X, "roll-non-fullscreen")) : (o(X, "roll-non-fullscreen"), l(X, "roll-fullscreen"))
                        })
                    }
                })
            }
        })
    }

    var s = function (e) {
        // player.ready(function () {
        //     t(this, e)
        // })
    };
    return (
        (e = e && e.hasOwnProperty("default") ? e.default : e).registerPlugin || e.plugin
    )("vroll", s),
        s
});

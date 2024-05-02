!(function (a) {
  "use strict";
  function t() {
    (this.$body = a("body")),
      (this.$chatInput = a(".chat-input")),
      (this.$chatList = a(".conversation-list")),
      (this.$chatSendBtn = a(".chat-send")),
      (this.$chatForm = a("#chat-form"));
  }
  (t.prototype.save = function () {
    var t = this.$chatInput.val(),
      i = moment().format("h:mm");
    return "" == t
      ? (this.$chatInput.focus(), !1)
      : (a(
          '<li class="clearfix odd"><div class="chat-avatar"><img src="assets/images/users/avatar-1.jpg" alt="male"><i>' +
            i +
            '</i></div><div class="conversation-text"><div class="ctext-wrap"><i>Dominic</i><p>' +
            t +
            "</p></div></div></li>"
        ).appendTo(".conversation-list"),
        this.$chatInput.focus(),
        this.$chatList.animate(
          { scrollTop: this.$chatList.prop("scrollHeight") },
          1e3
        ),
        !0);
  }),
    (t.prototype.init = function () {
      var i = this;
      i.$chatInput.keypress(function (t) {
        if (13 == t.which) return i.save(), !1;
      }),
        i.$chatForm.on("submit", function (t) {
          return (
            t.preventDefault(),
            i.save(),
            i.$chatForm.removeClass("was-validated"),
            i.$chatInput.val(""),
            !1
          );
        });
    }),
    (a.ChatApp = new t()),
    (a.ChatApp.Constructor = t);
})(window.jQuery),
  (function () {
    "use strict";
    window.jQuery.ChatApp.init();
  })();

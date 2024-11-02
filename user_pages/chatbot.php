<script>

    //start open-close chat
$("#chat-circle").click(function () {
  $("#chat-circle").toggle("scale");
  $(".chat-box").toggle("scale");
});

$(".chat-box-toggle").click(function () {
  $("#chat-circle").toggle("scale");
  $(".chat-box").toggle("scale");
});
//end open-close chat
var chats = [];
generate_message(
  "assistant",
  "Hello! Im Waqtify How can I help make your day easier?"
);

var INDEX = 0;
$("#chat-submit").click(function (e) {
  e.preventDefault();
  var msg = $("#chat-input").val();
  if (msg.trim() == "") {
    return false;
  }
  generate_message("user", msg);

  // Fetch request to send chats to ai.js
  fetch("ai.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(chats),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data, "k");

      // Assuming the response contains the assistant's message
      generate_message("assistant", data.message);
      $("#chat-submit").prop("disabled", false).css("color", "#5A5EB9");
    })
    .catch((error) => {
      console.error("Error:", error);
    });
});

function generate_message(type, msg) {
  chats.push({ role: type, content: msg });
  console.log(chats);

  INDEX++;
  var str = "";
  str += "<div id='cm-msg-" + INDEX + "' class=\"chat-msg " + type + '">';
  str += '          <span class="msg-avatar">';
  str += '            <img src="../img/logo1.png">';
  str += "          </span>";
  str += '          <div class="cm-msg-text">';
  str += msg;
  str += "          </div>";
  str += "        </div>";
  $(".chat-logs").append(str);
  $("#cm-msg-" + INDEX)
    .hide()
    .fadeIn(300);
  if (type == "user") {
    $("#chat-submit").prop("disabled", true).css("color", "grey");
    $("#chat-input").val("");
  }
  $(".chat-logs")
    .stop()
    .animate({ scrollTop: $(".chat-logs")[0].scrollHeight }, 1000);
  //$("#chat-submit").prop("disabled", false).css("color", "#5A5EB9");
}



</script>
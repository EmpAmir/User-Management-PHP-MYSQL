// Ajax req for retreive data
$(document).ready(function () {
  function showSell() {
    $("#sellAdd").click(function () {
      let orid = $("#id").val();
      let uname = $("#user_name").val();
      let pw = $("#inr_total1").val();
      let ut = $("#utr").val();
      mydata = { id: orid, user_name: uname, inr_total1: pw, utr: ut };
      console.log(mydata);
      $.ajax({
        url: "insert_sell.php",
        method: "POST",
        data: JSON.stringify(mydata),
        success: function (data) {
          console.log(data);
          msg = "<div>" + data + "</div>";
          $("#msg").html(msg);
          $("#sell_Form")[0].reset();
          showSell();
        },
      });
    });
  }
  showSell();
});
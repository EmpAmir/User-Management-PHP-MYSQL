// Ajax req for retreive data
$(document).ready(function () {
    function showdata() {
      output = "";
      $.ajax({
        url: "retrieve.php",
        method: "GET",
        dataType: "json",
        success: function (data) {
          // console.log(data);
          if (data) {
            x = data;
          } else {
            x = "";
          }
          for (i = 0; i < x.length; i++) {
            output +=
              "<tr><td>" +
              x[i].id +
              "</td><td>" +
              x[i].name +
              "</td><td>" +
              x[i].email +
              "</td><td>" +
              x[i].password +
              "</td><td><button class='btn btn-warning btn-sm btn-edit'data-sid=" +
              x[i].id +
              ">EDIT</button> <button class='btn btn-danger btn-sm btn-del' data-sid=" +
              x[i].id +
              ">DELETE</button></td><tr>";
          }
          $("#tbody").html(output);
        },
      });
    }
    showdata();
  
    // Ajax req for insert data
    $("#btnAdd").click(function (e) {
      e.preventDefault();
      let orid = $("#id").val();
      let nm = $("#usdt_rate").val();
      let em = $("#usdt_total").val();
      let pw = $("#inr_total").val();
      mydata = { id: orid, usdt_rate: nm, usdt_total: em, inr_total: pw };
      // console.log(mydata);
      $.ajax({
        url: "insert.php",
        method: "POST",
        data: JSON.stringify(mydata),
        success: function (data) {
          // console.log(data);
          msg = "<div>" + data + "</div>";
          $("#msg").html(msg);
          $("#order_Form")[0].reset();
          showdata();
        },
      });
    });
  
    // Ajax delete for  data
    $("tbody").on("click", ".btn-del", function () {
      // console.log("delete");
      let id = $(this).attr("data-sid");
      // console.log(id);
      mydata = { sid: id };
      mythis = this;
      $.ajax({
        url: "delete.php",
        method: "POST",
        data: JSON.stringify(mydata),
        success: function (data) {
          if (data == 1) {
            msg =
              "<div class='alert-danger text-center mt-2'>Student Deleted Sucessfully!!</div>";
            $(mythis).closest("tr").fadeOut();
          } else if (data == 0) {
            msg =
              "<div class='alert-danger text-center'>Unable to Delete!!</div>";
          }
          // console.log(data);
          $("#msg").html(msg);
          // showdata();
        },
      });
    });
    // Ajax editing for  data
    $("tbody").on("click", ".btn-edit ", function () {
      console.log("Edit Btn Clicked");
      let id = $(this).attr("data-sid");
      // console.log(id);
      mydata = { sid: id };
      $.ajax({
        url: "edit.php",
        method: "POST",
        dataType: "JSON",
        data: JSON.stringify(mydata),
        success: function (data) {
          // console.log(data);
          $("#stuId").val(data.id);
          $("#nameId").val(data.name);
          $("#emailId").val(data.email);
          $("#passwordId").val(data.password);
        },
      });
    });
  });
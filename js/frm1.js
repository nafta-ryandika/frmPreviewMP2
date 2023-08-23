$(document).ready(function() {
  $("#frmloading").hide();
  $("#tabelinput").hide();
  $("#innomp").focus();
});

function enterfind(event) {
  if (event.keyCode == 13) {
    check_mp(); 
  }
  else {
      return;
  }
}

function check_mp(){
  if (($("#innomp").val()) == "" ) {
    alert("Input No MP Kosong !");
    $("#innomp").focus();
    return;
  }
  else {
    var data = "intxtmode=check_mp&innomp="+$("#innomp").val()+"";
    $.ajax({
      url: "actfrm.php",
      type: "POST",
      data: data,
      cache: false,
      success: function(data){
        if (data == 2) {
          view_mp(data);
        }
        else if (data == 3) {
          view_mp(data);
        }
        else if (data == 4) {
          view_mp(data);
        }
        else if (data == 1) {
          alert("No. MP Tersebut Belum di Issued !");
          $("#innomp").val("");
        }
        else if (data == 0){
          openDialog("article");
        }
      }
    })
  }
}

function view_mp(status) {
  $("#indata").val($("#innomp").val());
  $("#instatus").val(status);

  $("#frmbody").slideUp("slow", function() {
    $("#frmloading").slideDown("slow", function() {
      $.ajax({
        url: "frmview.php",
        type: "POST",
        data: "innomp=" + $("#innomp").val() +"&instatus=" + status,
        cache: false,
        success: function(html) {
          $("#frmcontent").html(html);
          $("#frmbody").slideDown("slow", function() {
            $("#frmloading").slideUp("slow");
          });
        }
      });
    });
  });
}

function check_mp2(){
  if (($("#innomp").val()) == "" ) {
    alert("Input No MP Kosong !");
    $("#innomp").focus();
    return;
  }
  else {
    var data = "intxtmode=check_mp&innomp="+$("#innomp").val()+"";
    $.ajax({
      url: "actfrm.php",
      type: "POST",
      data: data,
      cache: false,
      success: function(data){
        if (data == 2) {
          exportclick(data);
        }
        else if (data == 3) {
          exportclick(data);
        }
        else if (data == 4) {
          exportclick(data);
        }
        else if (data == 1) {
          alert("No. MP Tersebut Belum di Issued !");
          $("#innomp").val("");
        }
        else if (data == 0){
          openDialog("article");
        }
      }
    })
  }
}

function openDialog(id) {
  if (id == "article") {
    var data ="article="+$("#txtdata0").val()+"";
    $.ajax({
      url: "frmmodal_article.php",
      data: data,
      type: "POST",
      cache: false,
      beforeSend: function() {
        openDialog('loading');
      },
      success: function(html) {
        $("#frmbody").slideDown("slow");
        $("#dialog-open").html(html);

        var width = screen.width;
        var height = screen.height;
        var lebar = width * 85 / 100;
        var tinggi = height * 60 / 100;

        $("#dialog-open").dialog({
          autoOpen: true,
          modal: true,
          height: tinggi,
          width: lebar,
          title: "Preview MP",
          close: function(event) {
            $("#dialog-open").hide();
            $("#dialog-open").html("");
          }
        });
      }
    });
  }
  else if (id == "loading") {
    $.ajax({
      url: "frmmodal_loading.php",
      data: data,
      type: "POST",
      cache: false,
      success: function(html) {
        $("#frmbody").slideDown("slow");
        $("#dialog-open").html(html);

        var width = screen.width;
        var height = screen.height;
        var lebar = width * 20 / 100;
        var tinggi = height * 20 / 100;

        $("#dialog-open").dialog({
          autoOpen: true,
          modal: true,
          height: "150",
          width: "150",
          title: "Please Wait ...",
          my:'center',of:'center',collison:'fit',
          close: function(event) {
            $("#dialog-open").hide();
            $("#dialog-open").html("");
          }
        });
      }
    });
  }
}

function exportclick(status) {
  $("#indata").val($("#innomp").val());
  $("#instatus").val(status);

  var exptype = $("#exporttype").val();
  switch (exptype) {
    case "pdf":
      $("#formexport").attr("action", "frmviewpdf.php");
      $("#formexport").submit();
      break;
    default:
      alert("Unidentyfication Type");
  }
}

function close_detailMP() {
  $("#intxtmode").val("");
  $("#mode").text("");
  $("#tabelinput").fadeOut("slow", function() {
    $("#tabelview").fadeIn("slow", findclick());
  });
}

function searchclick() {
  if ($("#areasearch").is(":hidden")) {
    $("#areasearch").slideDown("slow");
  } else {
    $("#areasearch").slideUp("slow");
  }
}

// ******************************* START JS MULTISEARCH ***************************************
var xrow = 1;
function addSearch() {
  var table = document.getElementById("tblSearch");

  // Create an empty <tr> element and add it to the 1st position of the table:
  var row = table.insertRow(xrow);

  // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  var cell5 = row.insertCell(4);

  //        cell2.className = 'txtmultisearch';

  // Add some text to the new cells:
  cell1.innerHTML =
    "Field : \n\
                            <select class='txtfield' id='txtfield" +
    xrow +
    "' onchange=\"setFilterData(" +
    xrow +
    ")\">\n\
                            <option value=''-</option>\n\
                            <option value='cust'>Customer</option>\n\
                            <option value='ordno'>Order No</option>\n\
                            <option value='mpno'>MP No</option>\n\
                            <option value='DATE_FORMAT(a.dateiss,'%d/%m/%Y')'>Date Issued</option>\n\
                            <option value='DATE_FORMAT(a.datepor,'%d/%m/%Y')'>Date PO received</option>\n\
                            <option value='article'>Article</option>\n\
                            <option value='last'>Last</option>\n\
                            <option value='noso'>No SO</option>\n\
                            <option value='colour'>Colour</option>\n\
                            <option value='category'>Category</option>\n\
                            <option value='DATE_FORMAT(a.dd,'%d/%m/%Y')'>Due Date</option>\n\
                            </select>";
  cell2.innerHTML =
    "<select class='txtparameter'>\n\
                                <option value='equal'>equal (=)</option>\n\
                                <option value='notequal'>not equal (!=)</option>\n\
                                <option value='less'>less (<)</option>\n\
                                <option value='lessorequal'>less or equal (<=)</option>\n\
                                <option value='greater'>greater (>)</option>\n\
                                <option value='greaterorequal'>greater or equal (>=)</option>\n\
                                <option value='isnull'>is null</option>\n\
                                <option value='isnotnull'>is not null</option>\n\
                                <option value='isnotnull'>is not null</option>\n\
                                <option value='isin'>is in</option>\n\
                                <option value='isnotin'>is not in</option>\n\
                                <option value='like'>like</option>\n\
                            </select>";
  cell3.innerHTML =
    "<div id='filter_data" +
    xrow +
    "'>Data : <input type='text' class='txtdata' onkeydown='enterfind(event)'></div>";
  cell4.innerHTML = "<input type='button' value='[+]' onclick='addSearch()'>";
  cell5.innerHTML =
    "<input type='button' value='remove' onclick=\"deleteRow(this)\" style='cursor:pointer;'>";

  xrow++;
}

function deleteRow(btn) {
  //
  if (btn == "rmv1") {
    $("#txtfield0").val("");
    $("#txtparameter0").val("equal");

    var data_select =
      "Data : <input type='text' class='txtdata' onkeydown='enterfind(event)'>";

    $("#filter_data0").html(data_select);
    $("#txtdata0").val("");
  } else {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    xrow--;
  }
}

function setFilterData(rowx) {
  if ($("#txtfield" + rowx).val() == "kategori") {
    $.ajax({
      url: "actfrm.php",
      type: "POST",
      data: "intxtmode=getkategori",
      cache: false,
      success: function(data_select) {
        $("#filter_data" + rowx).html(data_select);
      }
    });
  } else {
    var data_select =
      "Data : <input type='text' class='txtdata' onkeydown='enterfind(event)'>";

    $("#filter_data" + rowx).html(data_select);
  }
}

// ******************************* END JS MULTISEARCH ***************************************

function showpage(page) {
  $("#txtpage").val(page);
  findclick();
}

function showpage_modal(page) {
  $("#txtpagemodal").val(page);
  findclick_modal();
}

function prevpage() {
  var n = eval($("#txtpage").val()) - 1;
  if (n >= 1) {
    $("#txtpage").val(n);
    findclick();
  }
}

function prevpage_modal() {
  var n = eval($("#txtpagemodal").val()) - 1;
  if (n >= 1) {
    $("#txtpagemodal").val(n);
    findclick_modal();
  }
}

function nextpage() {
  var n = eval($("#txtpage").val()) + 1;
  if (eval(n) <= eval($("#jumpage").val())) {
    $("#txtpage").val(n);
    findclick();
  }
}

function nextpage_modal() {
  var n = eval($("#txtpagemodal").val()) + 1;
  if (eval(n) <= eval($("#jumpagemodal").val())) {
    $("#txtpagemodal").val(n);
    findclick_modal();
  }
}

$(function() {
  $("#intgl").datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth: true,
    changeYear: true
  });
});

function MyValidDate(dateString) {
  var validformat = /^\d{1,2}\/\d{1,2}\/\d{4}$/; //Basic check for format validity
  if (!validformat.test(dateString)) {
    return "";
  } else {
    //Detailed check for valid date ranges
    var dayfield = dateString.substring(0, 2);
    var monthfield = dateString.substring(3, 5);
    var yearfield = dateString.substring(6, 10);
    var MyNewDate = monthfield + "/" + dayfield + "/" + yearfield;
    if (checkValidDate(MyNewDate) == true) {
      var SQLNewDate = yearfield + "/" + monthfield + "/" + dayfield;
      return SQLNewDate;
    } else {
      return "";
    }
  }
}

function checkValidDate(dateStr) {
  // dateStr must be of format month day year with either slashes
  // or dashes separating the parts. Some minor changes would have
  // to be made to use day month year or another format.
  // This function returns True if the date is valid.
  var slash1 = dateStr.indexOf("/");
  if (slash1 == -1) {
    slash1 = dateStr.indexOf("-");
  }
  // if no slashes or dashes, invalid date
  if (slash1 == -1) {
    return false;
  }
  var dateMonth = dateStr.substring(0, slash1);
  var dateMonthAndYear = dateStr.substring(slash1 + 1, dateStr.length);
  var slash2 = dateMonthAndYear.indexOf("/");
  if (slash2 == -1) {
    slash2 = dateMonthAndYear.indexOf("-");
  }
  // if not a second slash or dash, invalid date
  if (slash2 == -1) {
    return false;
  }
  var dateDay = dateMonthAndYear.substring(0, slash2);
  var dateYear = dateMonthAndYear.substring(
    slash2 + 1,
    dateMonthAndYear.length
  );
  if (dateMonth == "" || dateDay == "" || dateYear == "") {
    return false;
  }
  // if any non-digits in the month, invalid date
  for (var x = 0; x < dateMonth.length; x++) {
    var digit = dateMonth.substring(x, x + 1);
    if (digit < "0" || digit > "9") {
      return false;
    }
  }
  // convert the text month to a number
  var numMonth = 0;
  for (var x = 0; x < dateMonth.length; x++) {
    digit = dateMonth.substring(x, x + 1);
    numMonth *= 10;
    numMonth += parseInt(digit);
  }
  if (numMonth <= 0 || numMonth > 12) {
    return false;
  }
  // if any non-digits in the day, invalid date
  for (var x = 0; x < dateDay.length; x++) {
    digit = dateDay.substring(x, x + 1);
    if (digit < "0" || digit > "9") {
      return false;
    }
  }
  // convert the text day to a number
  var numDay = 0;
  for (var x = 0; x < dateDay.length; x++) {
    digit = dateDay.substring(x, x + 1);
    numDay *= 10;
    numDay += parseInt(digit);
  }
  if (numDay <= 0 || numDay > 31) {
    return false;
  }
  // February can't be greater than 29 (leap year calculation comes later)
  if (numMonth == 2 && numDay > 29) {
    return false;
  }
  // check for months with only 30 days
  if (numMonth == 4 || numMonth == 6 || numMonth == 9 || numMonth == 11) {
    if (numDay > 30) {
      return false;
    }
  }
  // if any non-digits in the year, invalid date
  for (var x = 0; x < dateYear.length; x++) {
    digit = dateYear.substring(x, x + 1);
    if (digit < "0" || digit > "9") {
      return false;
    }
  }
  // convert the text year to a number
  var numYear = 0;
  for (var x = 0; x < dateYear.length; x++) {
    digit = dateYear.substring(x, x + 1);
    numYear *= 10;
    numYear += parseInt(digit);
  }
  // Year must be a 2-digit year or a 4-digit year
  if (dateYear.length != 2 && dateYear.length != 4) {
    return false;
  }
  // if 2-digit year, use 50 as a pivot date
  if (numYear < 50 && dateYear.length == 2) {
    numYear += 2000;
  }
  if (numYear < 100 && dateYear.length == 2) {
    numYear += 1900;
  }
  if (numYear <= 0 || numYear > 9999) {
    return false;
  }
  // check for leap year if the month and day is Feb 29
  if (numMonth == 2 && numDay == 29) {
    var div4 = numYear % 4;
    var div100 = numYear % 100;
    var div400 = numYear % 400;
    // if not divisible by 4, then not a leap year so Feb 29 is invalid
    if (div4 != 0) {
      return false;
    }
    // at this point, year is divisible by 4. So if year is divisible by
    // 100 and not 400, then it's not a leap year so Feb 29 is invalid
    if (div100 == 0 && div400 != 0) {
      return false;
    }
  }
  // date is valid
  return true;
}
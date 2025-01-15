$(document).ready(function () {
    runStart();
    customSelect();

    $('.uitablerecords tbody input[type="checkbox"]').change(function () {
        if ($(this).is(":checked")) {
            $(this).parent().parent().parent().addClass("selected");
        } else {
            $(this).parent().parent().parent().removeClass("selected");
        }
        getSelectedCheckboxCount();
    });

    $(".uiactionedit").click(function () {
        var selrow = $(this).closest("tr");
        selrow.find($(".uirowdisplay")).css("display", "none");
        selrow.find($(".uirowedit")).css("display", "block");
    });

    $(".uiactioneditcancel").click(function () {
        var selrow = $(this).closest("tr");
        selrow.find($(".uirowdisplay")).css("display", "block");
        selrow.find($(".uirowedit")).css("display", "none");
    });

    $(".date-single").daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: true,
        linkedCalendars: false,
        showCustomRangeLabel: false,
        alwaysShowCalendars: true,
        drops: "auto",
        buttonClasses: "uibutton",
        applyButtonClasses: "",
        cancelClass: "uisecondary"
    });
    $('.date-single').on("apply.daterangepicker", function (ev, picker) {
        $(this).val(picker.startDate.format("MM/DD/YYYY"));
    });
});

$(window).resize(function () {
    runStart();
});

window.onscroll = function() {myFunction()};

function myFunction() {

    var headerHeight = $("header").outerHeight();
    var filterHeight = $(".uioptiongroup").outerHeight();
    var breadcrumbsheight = $(".uibreadcrumbs").outerHeight();

    if (window.pageYOffset > breadcrumbsheight) {
        $('body').addClass('scrolled');
        $(".scrolled .uioptiongroup").css("top", headerHeight);
    } else {
        $('body').removeClass('scrolled');
    }
}

function runStart() {
    var windowHeight = window.innerHeight;
    var headerHeight = $("header").outerHeight();
    var footerHeight = $("footer").outerHeight();
    var adjsHeight = headerHeight + footerHeight;
    $(".uicontainer").css("min-height", windowHeight - adjsHeight);
    $("body").css("padding-top", headerHeight);
}

function getSelectedCheckboxCount() {
    var ItemsTotal = document.querySelectorAll('.uitablerecords tbody input[type="checkbox"]').length;
    var selectedItemsTotal = document.querySelectorAll('.uitablerecords tbody input[type="checkbox"]:checked').length;

    if (ItemsTotal == selectedItemsTotal) {
        $('.uitablerecords thead input[type="checkbox"]').prop("checked", true);
    } else {
        $('.uitablerecords thead input[type="checkbox"]').prop("checked", false);
    }
}

$(function () {
    $("table").tablesorter({
        sortReset: true,
        sortRestart: true,
        headers: {
            ".uiselectcol, .uiactioncol": {
                sorter: false,
            },
        },



    });

    $('.uiselectcol input[type="checkbox"]').change(function () {
        if ($(this).is(":checked")) {
            $('.uitablerecords tbody input[type="checkbox"]').prop('checked', true);
            $('.uitablerecords tbody tr').addClass('selected');
        } else {
            $('.uitablerecords tbody input[type="checkbox"]').prop('checked', false);
            $('.uitablerecords tbody tr').removeClass('selected');
        }
        getSelectedCheckboxCount();
    });
});

function customSelect() {
    var x, i, j, l, ll, selElmnt, a, b, c;
    /*look for any elements with the class "custom-select":*/
    x = document.getElementsByClassName("uicustomselect");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /*for each element, create a new DIV that will act as the selected item:*/
        a = document.createElement("DIV");
        if (selElmnt.disabled == true) {
            a.setAttribute("class", "select-selected disabled");
        } else {
            a.setAttribute("class", "select-selected");
        }
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /*for each element, create a new DIV that will contain the option list:*/
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < ll; j++) {
            /*for each option in the original select element,
            create a new DIV that will act as an option item:*/
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function (e) {
                /*when an item is clicked, update the original select box,
                and the selected item:*/
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function (e) {
            /*when the select box is clicked, close any other select boxes,
            and open/close the current select box:*/
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }

    function closeAllSelect(elmnt) {
        /*a function that will close all select boxes in the document,
        except the current select box:*/
        var x,
            y,
            i,
            xl,
            yl,
            arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i);
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }
    /*if the user clicks anywhere outside the select box,
    then close all select boxes:*/
    document.addEventListener("click", closeAllSelect);
}

(function () {
    "use strict";
    window.addEventListener(
        "load",
        function () {
            var forms = document.getElementsByClassName("needs-validation");
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener(
                    "submit",
                    function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                            form.classList.add("with-error");
                            $(".modal").modal("hide");
                        } else {
                        }
                        form.classList.add("was-validated");
                    },
                    false
                );
            });
        },
        false
    );
})();

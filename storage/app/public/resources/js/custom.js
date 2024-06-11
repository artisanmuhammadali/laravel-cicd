$(document).on("click", ".clos", function () {
    $("#edit_size").modal("hide");
});
// flip_card
const flipCardWrapAll = document.querySelector("#flip-card-wrap-all");
const cardsWrapper = document.querySelectorAll(".flip-card-3D-wrapper");
const cards = document.querySelectorAll(".flip-card");
let frontButtons = "";
let backButtons = "";

for (let i = 0; i < cardsWrapper.length; i++) {
    frontButtons = cardsWrapper[i].querySelector(".flip-card-btn-turn-to-back");
    frontButtons.style.visibility = "visible";
    frontButtons.onclick = function () {
        cards[i].classList.toggle("do-flip");
    };

    backButtons = cardsWrapper[i].querySelector(".flip-card-btn-turn-to-front");
    backButtons.style.visibility = "visible";
    backButtons.onclick = function () {
        cards[i].classList.toggle("do-flip");
    };
}

// from reset
$(document).on("click", ".close_btn_reset", function () {
    $(".submit_form").trigger("reset");
});
// form ajax

$(document).on("submit", ".submit_form", function (e) {
    e.preventDefault();
    if (!validate()) return false;
    if ($("div").hasClass("alert-dangers")) {
        return false;
    }
    // toastr.info("Please wait your request has sent.");
    var form = $(this);
    var submit_btn = $(form).find(".submit_btn");
    $(submit_btn).prop("disabled", true);
    $(submit_btn).closest("div").find(".loader").removeClass("d-none");
    // console.log(from);
    var data = new FormData(this);
    $(form).find(".submit_btn").prop("disabled", true);
    $.ajax({
        type: "POST",
        data: data,
        cache: !1,
        contentType: !1,
        processData: !1,
        url: $(form).attr("action"),
        async: true,
        headers: {
            "cache-control": "no-cache",
        },
        success: function (response) {
            if (response.error) {
                $(submit_btn).closest("div").find(".loader").addClass("d-none");
                toastr.error(response.error);
            }
            if (response.success) {
                toastr.success(response.success);
            }
            setTimeout(function () {
                window.location.href = response.redirect
                    ? response.redirect
                    : "/";
            }, 3000);
            if (response.modal) {
                window.location.href = response.modal;
            }

            $(submit_btn).prop("disabled", false);
            $(submit_btn).closest("div").find(".loader").addClass("d-none");
        },
        error: function (xhr, status, error) {
            $(submit_btn).prop("disabled", false);
            $(submit_btn).closest("div").find(".loader").addClass("d-none");
            if (xhr.status == 422) {
                $(form).find("div.alert").remove();
                var errorObj = xhr.responseJSON.errors;
                $.map(errorObj, function (value, index) {
                    var appendIn = $(form)
                        .find('[name="' + index + '"]')
                        .closest("div");
                    if (!appendIn.length) {
                        toastr.error(value[0]);
                    } else {
                        $(appendIn).append(
                            '<div class="alert alert-danger" style="padding: 1px 10px;font-size: 12px"> ' +
                                value[0] +
                                "</div>"
                        );
                    }
                });
                $(form).find(".submit_btn").prop("disabled", false);
            } else {
                $(form).find(".submit_btn").prop("disabled", false);
                toastr.error("Unknown Error!");
            }
        },
    });
});

function validate() {
    var valid = true;
    var div = "";
    $(".alert-danger").remove();
    $(".required:visible").each(function () {
        if (
            $(this).val() == "" ||
            $(this).val() === null ||
            $(this).attr("type") == "radio" ||
            ($(this).attr("type") == "checkbox" &&
                $('[name="' + $(this).attr("name") + '"]:checked').val() ==
                    undefined)
        ) {
            $(this).attr("type") == "checkbox" ? (div = ".row") : (div = "div");
            var name = $(this).attr("name");
            // console.log(name);
            $(this)
                .closest(div)
                .append(
                    '<div class="alert-danger" data-field=' +
                        name +
                        ">This field is required</div>"
                );
            valid = false;
        }
    });
    if (!valid) {
        var input = $(".alert-danger:first").attr("data-field");
        $('[name="' + input + '"]').focus();
    }
    return valid;
}

// expansion pg search
$(document).on("keyup", ".expansionSearch", function (e) {
    var value = $(this).val().toLowerCase();
    if (value) {
        $(".expSearchCross").removeClass("d-none");
    } else {
        $(".expSearchCross").addClass("d-none");
    }
    searchExpansion(value);
});
// revert expansion search
$(document).on("click", ".expSearchCross", function () {
    var value = "";
    $(".expansionSearch").val(value);
    searchExpansion(value);
});
// expansion search function
function searchExpansion(value) {
    var ul = $(".list-group");
    //get all lis but not the one having search input
    var li = ul.find("li:gt(0)");
    //hide all lis
    li.hide();
    li.filter(function () {
        var text = $(this).text().toLowerCase();
        return text.indexOf(value) >= 0;
    }).show();
}
// expansion pg sorting
$(document).on("change", "#parameter , #alignment", function () {
    var param = $("#parameter").val();
    var align = $("#alignment").val();
    if (param != "legality") {
        var html = `
                <option class="form-control" value="desc">Descending</option>
                <option class="form-control" value="asc">Ascending</option>
        `;
        $("#alignment").html(html);
        var params = ["asc", "desc"];
        var align2 = params.includes(align) ? align : "desc";
        $("#alignment").val(align2);
    } else {
        var html = `
            <option class="form-control text-capitalize" value="standard">standard</option>
            <option class="form-control text-capitalize" value="pioneer">pioneer</option>
            <option class="form-control text-capitalize" value="modern">modern</option>
            <option class="form-control text-capitalize" value="legacy">legacy</option>
            <option class="form-control text-capitalize" value="pauper">pauper</option>
            <option class="form-control text-capitalize" value="vintage">vintage</option>
            <option class="form-control text-capitalize" value="commander">commander</option>
            <option class="form-control text-capitalize" value="oldschool">oldschool</option>
            <option class="form-control text-capitalize" value="premodern">premodern</option>
        `;
        $("#alignment").html(html);
    }
    if (param == "name") {
        ExpNameSorting(align);
    }
    if (param == "released_at") {
        ExpReleaseDateSorting(align);
    }
    if (param == "legality") {
        var url = $("#parameter").attr("data-url");
        ExpLegalityFilter(align, url);
    }
});
//filter expansion list according to legality
function ExpLegalityFilter(legality, url) {
    var legalitiesArr = [
        "standard",
        "future",
        "historic",
        "gladiator",
        "pioneer",
        "explorer",
        "modern",
        "legacy",
        "pauper",
        "vintage",
        "penny",
        "commander",
        "oathbreaker",
        "brawl",
        "historicbrawl",
        "alchemy",
        "paupercommander",
        "duel",
        "oldschool",
        "premodern",
        "predh",
    ];
    legality = legalitiesArr.includes(legality) ? legality : "standard";
    $.ajax({
        type: "GET",
        data: { format1: legality },
        url: url,
        success: function (response) {
            $(".renderExpansions").html(response.html);
            $("#alignment").val(legality);
        },
    });
}
// getting name lists for sorting expansion according to alphabets
function ExpNameSorting(align) {
    var expUl = $(".expSet");
    var spUl = $(".spSet");

    var listExp = expUl.find("li:gt(0)");
    var listSp = spUl.find("li:gt(0)");
    NameSort(listExp, expUl, align);
    NameSort(listSp, spUl, align);
}
// sorting expansion according to alphabets
function NameSort(list, ul, align) {
    list.sort(function (a, b) {
        var a = $(a).text(),
            b = $(b).text();
        if (align == "asc") {
            return a < b ? -1 : a > b ? 1 : 0;
        } else {
            return a > b ? -1 : a < b ? 1 : 0;
        }
    }).appendTo(ul);
}
// getting date lists for sorting expansion according to release date
function ExpReleaseDateSorting(align) {
    var expUl = $(".expSet");
    var spUl = $(".spSet");

    var listExp = expUl.find("li:gt(0)");
    var listSp = spUl.find("li:gt(0)");
    ReleaseDateSorting(listExp, expUl, align);
    ReleaseDateSorting(listSp, spUl, align);
}
// sorting expansion according to release date
function ReleaseDateSorting(list, ul, align) {
    list.sort(function (a, b) {
        var a = $(a).attr("data-date"),
            b = $(b).attr("data-date");
        if (align == "asc") {
            return new Date(a) - new Date(b);
        } else {
            return new Date(b) - new Date(a);
        }
    }).appendTo(ul);
}

// Show/Hide password field
$(".toggle-password").click(function () {
    $(this).toggleClass("fa-fw fa-eye");
    var input = $(this).closest(".row").find(".password-field_id");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

//set page data

$(document).on("click", ".set_page", function () {
    let page = $(this).data("page");
    let url = $(this).data("url");
    $.ajax({
        type: "GET",
        data: { page: page },
        url: url,
        success: function (response) {
            $(".append_setting_form_data").html(response.view);
            InlineEditor.create(document.querySelector("#editor")).catch(
                (error) => {
                    console.error(error);
                }
            );
        },
    });
});

$(document).on("keyup", ".setting_field", function () {
    let customClass = $(this).data("class");
    $("." + customClass + "_area").text($(this).val());
});

function toastrAlert(type, msg) {
    toastr.options.timeOut = 2500;
    if (type == "success") {
        toastr.success(msg);
    } else {
        toastr.error(msg);
    }
}
var readURL = function (input, customClass, customType) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            if (customType == "background") {
                // alert(e.target.result);
                // $('.'+customClass+'_area').css("background-image","url(data:image/png;base64," + e.target.result + ")");
                $("." + customClass + "_area").css(
                    "background-image",
                    "linear-gradient(rgba(33, 48, 86, 1), rgba(0, 0, 0, 0.5)), url(" +
                        e.target.result +
                        ")"
                );
            } else {
                $("." + customClass + "_area").attr("src", e.target.result);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
};

$(document).on("change", ".upload_image", function () {
    let customClass = $(this).data("class");
    let customType = $(this).data("type");

    readURL(this, customClass, customType);
});
// expensiton btn mbl
$(document).on("click", ".btn-sets", function () {
    let sets = $(this).data("class");
    if (sets == "expansion") {
        $(".exp-set").removeClass("d-none");
        $(".exp-s").addClass("active");
        $(".sp-set").addClass("d-none");
        $(".sp-s").removeClass("active");
    } else {
        $(".sp-set").removeClass("d-none");
        $(".sp-s").addClass("active");
        $(".exp-set").addClass("d-none");
        $(".exp-s").removeClass("active");
    }
});

// change icon image on login modal
$(document).on("keyup", ".password-field_id", function () {
    if ($(this).val() == "") {
        $(".no-typing").removeClass("d-none");
        $(".typing").addClass("d-none");
    } else {
        $(".no-typing").addClass("d-none");
        $(".typing").removeClass("d-none");
    }
});

var mouse_is_inside = false;

$(document).ready(function () {
    // Datatable Initalized
    var table = $(".datatables").DataTable({
        sort: false,
        ordering: false,
        pagingType: "full_numbers",
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        },
    });
    if (toastrMsg != undefined) {
        toastrAlert(toastrType, toastrMsg);
    }
    $(".search_tab_block").hover(
        function () {
            mouse_is_inside = true;
        },
        function () {
            mouse_is_inside = false;
        }
    );
    $("body").mouseup(function () {
        if (mouse_is_inside == false) {
            $(".search_tab_block").empty();
        }
    });
});

// general search

let tabb = "item";
$(document).on("click", ".search_tab", function () {
    tabb = $(this).data("type");
});
var timeout = null;

$(document).on("keyup", ".general_search_input", function (e) {

    let keyword = $(this).val();
    if (keyword.length >= 3) {
        if (e.code === "Enter") { 
            let urll = $('.redi_url').data('url');
            window.location.href =  urll +"?keyword=" + keyword;
        }
        let url = $(this).data("url");
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            $.ajax({
                type: "GET",
                data: { keyword: keyword, tabb: tabb },
                url: url,
                success: function (response) {
                    $(".search_tab_block").html(response.html);
                },
            });
            return true;
        }, 250);
    } else {
        $(".search_tab_block").html("");
    }
});
// show image name on change of input field [ Sell one like this ]

$(document).on("change", "#upload-photo", function (event) {
    var fileName = $(this)[0].files[0].name;
    var text = "File Name: " + fileName;
    $(".photoName").html(text);
});

$(document).on("click", ".expansion_detailed_route", function (event) {
    let url = $(this).data("url");
    window.location.href = url;
});
function isMobileScreen() {
    return window.innerWidth <= 760;
}
//cart system
$(document).on("click", ".add_to_cart", function () {
    let thatt = $(this);
    $('.checkout_btn').prop("disabled", true);
    var quantity = thatt.closest("div").find(".cart_quantity").val();
    var type = thatt.closest("div").find(".coll_type").val();
    let cart_url = thatt.attr("data-url");
    var removeFromIndex = thatt.hasClass("cartIndex");
    var mobile = isMobileScreen();
    $.ajax({
        type: "GET",
        data: { quantity: quantity , type :type ,mobile:mobile },
        url: cart_url,
        success: function (response) {
            if (response.error) {
                toastr.error(response.error);
                return false;
            }
            if (removeFromIndex) {
                window.location.reload();
            }
            $(".cart-span").text(response.total);
            thatt
                .closest("div")
                .find(".count_spec_item")
                .removeClass("hide")
                .text(response.count);
            toastr.success("Cart Added Successfully!");
            thatt
                .closest("div")
                .find(".remove_cart_item")
                .prop("disabled", false);
            $('.checkout_btn').prop("disabled", false);
        },
    });
});

$(document).on("click", ".remove_cart_item", function () {
    let thatt = $(this);
    var removeFromIndex = thatt.hasClass("cartIndex");
    let cart_url = thatt.attr("data-url");

    $.ajax({
        type: "GET",
        url: cart_url,
        success: function (response) {
            $(".cart-span").text(response.total);
            thatt.closest("div").find(".count_spec_item").addClass("hide");
            toastr.success("Cart Removed Successfully!");
            thatt
                .closest("div")
                .find(".remove_cart_item")
                .prop("disabled", true);
            if (removeFromIndex) {
                window.location.reload();
            }
        },
    });
});

// img-hovering-move
$(document).on("hover", ".h4Btn", function () {
    $(".h4").find("img").show();
});
$(document).on("mousemove", ".h4Btn", function (e) {
    $(".h4")
        .css("left", e.clientX + 10)
        .css("top", e.clientY - 300);
});
$(document).on("mousemove", ".h4Btn", function (e) {
    $(".hfix")
        .css("left", e.clientX + 10)
        .css("top", e.clientY - 150);
});

$(document).on("click", ".cart_btn", function (e) {
    e.preventDefault();
    let count = $('.count_cart_text').text();
    if(parseInt(count, 10) == 0)
    {
        toastr.error("Your cart is empty");
        return false;
    }
    window.location.href = $(this).data("url");
    
});
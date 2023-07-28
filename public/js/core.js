$(".addModal").on("click", function () {
    formReset();
    modalShow("myModal", "Add Data");
});

$(".addModalImport").on("click", function () {
    formReset();
    modalShow("myModal", "Import Data");
});

$("#myModal").on("hidden.bs.modal", function () {
    formReset();
});

function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}

function validateSwal(text) {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: `${text}`,
    }).then(function () {});
}

function validateDateInput(dt1, dt2) {
    if (dt1 == "") {
        validateSwal("Start Date Required", tgl1);
        // $("#tgl1").focus();
        return false;
    }

    if (dt2 == "") {
        validateSwal("End Date Required");
        // $("#tgl2").focus();
        return false;
    }

    if (dt1 > dt2) {
        validateSwal("Please Select Correct Date");
        return false;
    }
}

function activeInactiveColor(param) {
    let color;
    switch (param) {
        case 1:
            color = "success";
            break;
        case 0:
            color = "danger";
            break;
        default:
            color = "danger";
    }
    return color;
}

function unescapeHTML(escapedHTML) {
    return escapedHTML.replace(/&lt;/g, "<").replace(/&gt;/g, ">");
}

function swalStatus2(result, modalId, timer, table, modalHide = true) {
    let message = "";
    if (result.status == "error") {
        $.each(result.message, function (item, val) {
            message += ` <span class="la la-exclamation red"> ${val}</span><br>`;
        });
    } else {
        message = result.message;
    }
    Swal.fire({
        icon: `${result.status}`,
        title: `${result.status}`,
        html: message,
        showCancelButton: false,
        showConfirmButton: false,
        timer: 1000,
    }).then(() => {
        if (timer) {
            window.location.reload();
        }
        Swal.close();
        if (modalHide === true) modalHide(`${modalId}`);
        if (table) tableReload(table);
    });
}

function replaceNbsps(str) {
    var re = new RegExp(String.fromCharCode(160), "g");
    return str.replace(re, " ");
}

function swalStatus(result, modalId, timer, table) {
    let message = "";
    if (result.status == "error") {
        $.each(result.message, function (item, val) {
            message += ` <span class="la la-exclamation red"> ${val}</span><br>`;
        });
    } else {
        message = result.message;
    }
    Swal.fire({
        icon: `${result.status}`,
        title: `${result.status}`,
        html: message,
        showCancelButton: false,
        showConfirmButton: false,
        timer: 1000,
    }).then(() => {
        if (timer && result.status !== "error") {
            window.location.reload();
        }
        Swal.close();
        if (modalId) {
            modalHide(`${modalId}`);
        }
        if (table) tableReload(table);
    });
}

function swalSuccess(result, modalId) {
    Swal.fire({
        icon: "success",
        title: "Success",
        text: result.success,
        showCancelButton: false,
        showConfirmButton: false,
        timer: 1000,
    }).then(() => {
        Swal.close();
        modalHide(`${modalId}`);
        tableReload(table);
    });
}

function modalShow(modalId, modalTitle, ajax = null, selectedValue = null) {
    $(".modal-title").text(modalTitle);

    if (ajax) {
        let html = '<option value="" selected disabled>select value</option>';
        let selected = "";
        $.get(ajax, function (response) {
            if (response.data) {
                $.each(response.data, function (k, v) {
                    console.log(selectedValue === v.id);
                    if (selectedValue === v.id) {
                        selected = "selected";
                    }

                    if (v.name === undefined) {
                        html += `<option value="${v.id}" ${selected}>${v.content_head}</option>`;
                    } else {
                        html += `<option value="${v.id}" ${selected}>${v.name}</option>`;
                    }
                });
            }

            $("#parent").html(html);
        });
    }

    $(`#${modalId}`).modal("show");

    // $(`#${modalId}`).modal({backdrop: 'static', keyboard: false});
}

function modalHide(modalId) {
    $(`#${modalId}`).modal("hide");
}

function tableReload(tableName) {
    tableName.ajax.reload();
}

function formReset(select = false) {
    $("#formModal")[0].reset();
    $("#tbl-access tbody").html("");
    $("#id").val("");
    $("label.error").hide();
    $(".error").removeClass("error");
    $("#formModal fieldset").removeClass("validate", true);

    if (select) {
        $("#formModal select").val("").trigger("change");
    }

    formEnable();
}

function formDisable() {
    $("#formModal input").prop("disabled", true);
    $("#formModal textarea").prop("disabled", true);
    $("#formModal select").prop("disabled", true);
    $("#formModal button[type=submit]").prop("disabled", true);
}

function formEnable() {
    $("#formModal input").removeAttr("disabled", true);
    $("#formModal select").removeAttr("disabled", true);
    $("#formModal button").removeAttr("disabled", true);
}

function formEnableCustom(arrayField) {
    $("#formModal input").prop("disabled", true);
    $("#formModal textarea").prop("disabled", true);
    $("#formModal select").prop("disabled", true);
    // $("#formModal button[type=submit]").prop("disabled", true);
    $("#formModal button").removeAttr("disabled", true);

    $.each(arrayField, function (k, v) {
        $(`#${v}`).removeAttr("disabled", true);
    });
}

$(".number-only").on("input", function (event) {
    this.value = this.value.replace(/[^0-9]/g, "");
});
function convertToSlug(Text) {
    return Text.toLowerCase()
        .replace(/ /g, "-")
        .replace(/[^\w-]+/g, "");
}

const showParagraph = (targetId, paragraphText, displayLimit) => {
    const pTagElem = document.createElement("p");
    pTagElem.setAttribute("style", "word-break: break-all;");

    if (paragraphText.length > displayLimit) {
        const uniqueId = targetId || "body";
        const dotsSpanElem = document.createElement("span");
        dotsSpanElem.id = `dots-${uniqueId}`;
        dotsSpanElem.textContent = "...";
        dotsSpanElem.setAttribute("style", "display: inline");

        const moreTextSpanElem = document.createElement("span");
        moreTextSpanElem.id = `more-${uniqueId}`;
        moreTextSpanElem.setAttribute("style", "display: none");

        const toggleButtonElem = document.createElement("button");
        toggleButtonElem.id = `myBtn-${targetId}`;
        toggleButtonElem.onclick = () => toggle(targetId);
        toggleButtonElem.innerHTML = "Read more";
        toggleButtonElem.setAttribute(
            "style",
            "background: none !important; border: none; margin: 5px !important; padding: 0 !important; color: #069; text-decoration: underline; cursor: pointer;"
        );

        const firstText = paragraphText.slice(0, displayLimit);
        const secondText = paragraphText.slice(displayLimit);
        moreTextSpanElem.appendChild(document.createTextNode(secondText));

        pTagElem.appendChild(document.createTextNode(firstText));
        pTagElem.appendChild(dotsSpanElem);
        pTagElem.appendChild(moreTextSpanElem);
        pTagElem.appendChild(toggleButtonElem);
    } else {
        pTagElem.appendChild(document.createTextNode(paragraphText));
    }
    document.getElementById(targetId)
        ? document.getElementById(targetId).appendChild(pTagElem)
        : document.body.appendChild(pTagElem);
};

function thousands_separators(num) {
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num_parts.join(".");
}
const style = [
    {
        featureType: "water",
        elementType: "geometry",
        stylers: [
            {
                color: "#e9e9e9",
            },
            {
                lightness: 17,
            },
        ],
    },
    {
        featureType: "landscape",
        elementType: "geometry",
        stylers: [
            {
                color: "#f5f5f5",
            },
            {
                lightness: 20,
            },
        ],
    },
    {
        featureType: "road.highway",
        elementType: "geometry.fill",
        stylers: [
            {
                color: "#ffffff",
            },
            {
                lightness: 17,
            },
        ],
    },
    {
        featureType: "road.highway",
        elementType: "geometry.stroke",
        stylers: [
            {
                color: "#ffffff",
            },
            {
                lightness: 29,
            },
            {
                weight: 0.2,
            },
        ],
    },
    {
        featureType: "road.arterial",
        elementType: "geometry",
        stylers: [
            {
                color: "#ffffff",
            },
            {
                lightness: 18,
            },
        ],
    },
    {
        featureType: "road.local",
        elementType: "geometry",
        stylers: [
            {
                color: "#ffffff",
            },
            {
                lightness: 16,
            },
        ],
    },
    {
        featureType: "poi",
        elementType: "geometry",
        stylers: [
            {
                color: "#f5f5f5",
            },
            {
                lightness: 21,
            },
        ],
    },
    {
        featureType: "poi.park",
        elementType: "geometry",
        stylers: [
            {
                color: "#dedede",
            },
            {
                lightness: 21,
            },
        ],
    },
    {
        elementType: "labels.text.stroke",
        stylers: [
            {
                visibility: "on",
            },
            {
                color: "#ffffff",
            },
            {
                lightness: 16,
            },
        ],
    },
    {
        elementType: "labels.text.fill",
        stylers: [
            {
                saturation: 36,
            },
            {
                color: "#333333",
            },
            {
                lightness: 40,
            },
        ],
    },
    {
        elementType: "labels.icon",
        stylers: [
            {
                visibility: "off",
            },
        ],
    },
    {
        featureType: "transit",
        elementType: "geometry",
        stylers: [
            {
                color: "#f2f2f2",
            },
            {
                lightness: 19,
            },
        ],
    },
    {
        featureType: "administrative",
        elementType: "geometry.fill",
        stylers: [
            {
                color: "#fefefe",
            },
            {
                lightness: 20,
            },
        ],
    },
    {
        featureType: "administrative",
        elementType: "geometry.stroke",
        stylers: [
            {
                color: "#fefefe",
            },
            {
                lightness: 17,
            },
            {
                weight: 1.2,
            },
        ],
    },
];

function stringToArray(data) {
    return data.match(/\d(\.?[0-9])*/g).map(Number);
}

const showLoading = function () {
    Swal.fire({
        title: "Now loading",
        html: `<div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>`, // add html attribute if you want or remove
        allowEscapeKey: false,
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        // timer: 2000,
    }).then(() => {
        // Swal.fire(
        //     'Good job!',
        //     'You clicked the button!',
        //     'success'
        // )
    });
};

chartColors = {
    column: {
        series1: "#826af9",
        series2: "#d2b0ff",
        bg: "#f8d3ff",
    },
    success: {
        shade_100: "#7eefc7",
        shade_200: "#06774f",
    },
    donut: {
        series1: "#ffe700",
        series2: "#00d4bd",
        series3: "#826bf8",
        series4: "#2b9bf4",
        series5: "#FFA1A1",
    },
    area: {
        series3: "#a4f8cd",
        series2: "#60f2ca",
        series1: "#2bdac7",
    },
};

window.colors = {
    solid: {
        primary: "#7367F0",
        secondary: "#82868b",
        success: "#28C76F",
        info: "#00cfe8",
        warning: "#FF9F43",
        danger: "#EA5455",
        dark: "#4b4b4b",
        black: "#000",
        white: "#fff",
        body: "#f8f8f8",
    },
    light: {
        primary: "#7367F01a",
        secondary: "#82868b1a",
        success: "#28C76F1a",
        info: "#00cfe81a",
        warning: "#FF9F431a",
        danger: "#EA54551a",
        dark: "#4b4b4b1a",
    },
};

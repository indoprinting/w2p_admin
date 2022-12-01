$(document).ready(function () {
    $(".select2").select2({
        theme: "bootstrap4",
    });

    // table datatable
    $(function () {
        $("#datatable").DataTable({
            lengthMenu: [100, 200, 1000, 5000, 10000],
            responsive: false,
            autoWidth: false,
        });
    });
    $(function () {
        $(".datatable").DataTable({
            responsive: false,
            autoWidth: false,
        });
    });
    $(function () {
        $(".datatable2").DataTable({
            lengthMenu: [25, 100, 200, 1000, 5000, 10000],
            responsive: false,
            autoWidth: false,
        });
    });
    $(function () {
        $("#datatable2").DataTable({
            responsive: false,
            lengthMenu: [100, 200, 500, 2000],
            autoWidth: false,
        });
    });
    $(function () {
        $("#datatable3").DataTable({
            responsive: true,
            lengthMenu: [5, 10, 20, 50, 100],
            autoWidth: false,
        });
    });

    $(document).on("click", "#saveproduct", function () {
        $(".formAddProduct").submit();
    });

    // image preview
    $("input[type=file]").on("change", function () {
        if ($(this)[0].files[0]) {
            var reader = new FileReader();

            reader.onload = (e) => {
                $("#img-preview").attr("src", e.target.result);
            };

            reader.readAsDataURL($(this)[0].files[0]);
        }
    });

    $(function () {
        // Multiple images preview in browser
        var imagesPreview = function (input, placeToInsertImagePreview) {
            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function (event) {
                        $(
                            $.parseHTML(
                                '<img style="max-height:45%; max-width:45%;margin:10px;" class="img-thumbnail">'
                            )
                        )
                            .attr("src", event.target.result)
                            .appendTo(placeToInsertImagePreview);
                    };

                    reader.readAsDataURL(input.files[i]);
                }
            }
        };

        $("#img_product2").on("change", function () {
            $(".img-edit").hide();
            document.getElementById("img-preview2").innerHTML = "";
            imagesPreview(this, "div.img-preview2");
        });
    });

    $("#ukuran0").val($("#size_name0").val());
    let index;
    if (typeof count_size !== "undefined") {
        index = count_size;
    } else {
        index = 1;
    }
    // size and design
    $("#addSize").click(function () {
        $(".td_value_size").append(
            `<div class="form-group row size-design${index}">
          <div class="col-sm-4">
            <input type="text" class="form-control <?= ($valid->hasError('size_price')) ? 'is-invalid' : ''; ?>" name="size_price[]" placeholder="Harga (x bahan)">
          </div>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="size_name[]" id="size_name${index}" data-index="${index}" placeholder="Nama ukuran">
          </div>
          <div class="col-sm-1">
            <a id="removeSize" href="javascript:void(0);" class="fal fa-minus-circle" style="font-size: 34px;color:red" data-delete="${index}"></a>
          </div>
      </div>`
        );

        $(".value_design").append(
            `<tr class="size-design${index}">
        <td>
          <input type="text" class="form-control" name="ukuran[]" id="ukuran${index}" value="" readonly>
        </td>
        <td class="td_value_design">
            <div class="form-group row">
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="layout_name${index}[]">
                </div>
                <div style="margin-right: 20px;">
                    <a id="addDesign" href="javascript:void(0);" class="fal fa-plus-circle" style="font-size: 34px;color:darkmagenta;" data-design="${index}"></a>
                </div>
                <div class="col-sm-4">
                    <input type="file" name="img_design${index}[]" class="img_design" data-image="${index}">
                </div>
                <div class="col-sm-4" style="max-height:30%; max-width:30%;padding:0px">
                    <img src="" alt="" class="img-thumbnail img_preview design${index}">
                </div>
            </div>
        </td>
      </tr>`
        );

        // $(document).on("keyup", `#size_name${index}`, function () {
        //     $(`#ukuran${$(this).data("index")}`).val($(this).val());
        // });

        index++;
    });

    let image = 100;
    $(document).on("click", "#addDesign", function () {
        $(this).closest(".td_value_design").append(`
      <ww>
        <div class="form-group row">
          <div class="col-sm-3">
              <input type="text" class="form-control" name="layout_name${$(
                  this
              ).data("design")}[]">
          </div>
          <div style="margin-right: 20px;">
              <a id="remove" href="javascript:void(0);" class="fal fa-minus-circle" style="font-size: 34px;color:red;"></a>
          </div>
          <div class="col-sm-4">
              <input type="file" name="img_design${$(this).data(
                  "design"
              )}[]" class="img_design" data-image="${image}">
          </div>
          <div class="col-sm-4" style="max-height:30%; max-width:30%;padding:0px">
              <img src="" alt="" class="img-thumbnail img_preview design${image}">
          </div>
        </div>
        </ww>
      `);
        image++;
    });

    $(document).on("keyup", "#size_name0", function () {
        $(`#ukuran${$(this).data("index")}`).val($(this).val());
    });

    $(document).on("change", "#size_name0", function () {
        $(`#ukuran${$(this).data("index")}`).val($(this).val());
    });

    // $("#addMaterial").click(function () {
    //   $(".td_value_material").append(
    //     `<as><div class="form-group row"><div class="col-sm-4"><input type="text" class="form-control" name="material_name[]" placeholder="Jenis bahan"></div><div class="col-sm-3"><input type="text" class="form-control" name="material_price[]" placeholder="Harga"></div><div class="col-sm-1"><a id="removeVatb" href="javascript:void(0);" class="fal fa-minus-circle" style="font-size: 34px;color:red"></a></div></div></as>`
    //   );
    // });
    // remove value
    $(document).on("click", "#remove", function () {
        $(this).closest("ww").remove();
    });
    $(document).on("click", "#removeSize", function () {
        $(".size-design" + $(this).data("delete")).remove();
    });
    // end algorithm

    // preview image for design online
    $(document).on("change", ".img_design", function () {
        if ($(this)[0].files[0]) {
            var reader = new FileReader();

            reader.onload = (e) => {
                $(".design" + $(this).data("image")).attr(
                    "src",
                    e.target.result
                );
            };

            reader.readAsDataURL($(this)[0].files[0]);
        }
    });

    // add attributes
    let atb;
    if (typeof count_atb !== "undefined") {
        atb = count_atb;
    } else {
        atb = 0;
    }

    let atb_value = new Array();

    $("#bahan > option").each(function () {
        atb_value.push(
            `<option value="${$(this).val()}">${$(this).text()}</option>`
        );
    });
    $(document).on("click", "#addAtb", function () {
        $(".coloum_atb").append(
            `<tr class="custom_atb">
        <td style="vertical-align: top;"><div style="display:flex;">
          <a id="removeAtb" href="javascript:void(0);"><i class="fal fa-times" style="font-size: 20px;color:red;margin-right:5px;"></i></a>
            <input type="text" class="form-control" name="atb_name${atb}" placeholder="Nama atribut">
          </div>
        </td>
        <td class="td_value">
          <div class="col-sm-12">
            <select class="select2" multiple="multiple" name="value_name${atb}[]" data-placeholder="Pilih atribut" style="width: 100%;">
            ${atb_value}
            </select>
          </div>
        </td>
      </tr>`
        );
        $(".select2").select2({
            theme: "bootstrap4",
        });
        atb++;
    });
    // add value for attributes
    $(document).on("click", `#addValue`, function () {
        console.log($(this).data("atb"));
        $(this)
            .closest(".td_value")
            .append(
                `<as><div class="form-group row"><div class="col-sm-8"><input type="text" class="form-control" name="value_name${$(
                    this
                ).data(
                    "atb"
                )}[]" placeholder="Jenis atribut"></div><div class="col-sm-3"><input type="text" class="form-control" name="value_price${$(
                    this
                ).data(
                    "atb"
                )}[]" placeholder="Harga"></div><div class="col-sm-1"><a id="removeVatb" href="javascript:void(0);" class="fal fa-minus-circle" style="font-size: 34px;color:red"></a></div></div></as>`
            );
    });
    // remove value attributes
    $(document).on("click", `#removeVatb`, function () {
        $(this).closest("as").remove();
    });
    // delete attribute
    $(document).on("click", "#removeAtb", function () {
        $(this).closest(".custom_atb").remove();
    });
    // end add attributes
});

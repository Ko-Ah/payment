$('.odd').hide()
    function fetch(data) {
        for (var i = 0; i < data['categories'].length; i++) {

                $('tbody').append("<tr style='width: 100%;' data-column='" + data['categories'][i]['id'] + "'><td class='table-img'><img src='images/p-13.jpg' alt></td><td id='name'>" + data['categories'][i]['name'] + "</td><td id='subName' data-subname='" + data['categories'][i]['id'] + "'></td><td><div><a data-id='" + data['categories'][i]['id'] + "' class='btn btn-primary shadow btn-xs sharp m-1 edit' id='edit'  data-id='" + data['categories'][i]['id'] + "' data-subname data-toggle='modal' data-target='#modal_update_adduser'><i class='fa fa-pencil'></i></a><a data-id='" + data['categories'][i]['id'] + "' data-subname class='btn btn-danger shadow btn-xs sharp delete show_confirm m-1' data-toggle='tooltip' title='Delete'><i class='fa fa-trash'></i></a></div></td></tr>")

        }
        var tdName = document.querySelectorAll("#subName");
        for(var i = 0; i < tdName.length; i++){

            tdName[i].innerHTML ='<ul></ul>'
        }

        for (var i = 0; i < data['subCategories'].length; i++) {
        $("[data-column='" + data['subCategories'][i]['parent_id'] + "'] td#subName ul").append("<li data-subsubject='" + data['subCategories'][i]['id'] + "'>"+data['subCategories'][i]['name']+"</li>")
                if(data['subCategories'][i]['parent_id']){
                    var num =data['subCategories'][i]['parent_id'];
                    var tdSubName = document.querySelector("[data-column='" + data['subCategories'][i]['parent_id'] + "'] td#subName")
                      /*  tdSubName.innerText =data['subCategories'][i]['name'];
                            tdSubName.setAttribute('data-subname',data['subCategories'][i]['id'])*/
                    var BtnDelete = document.querySelector("[data-column='" + data['subCategories'][i]['parent_id'] + "'] .delete")
                    BtnDelete.setAttribute('data-subname',data['subCategories'][i]['id']);
                            var BtnEdit = document.querySelector("[data-column='" + data['subCategories'][i]['parent_id'] + "'] .edit")
                    BtnEdit.setAttribute('data-subname',data['subCategories'][i]['id']);

                 /*   $("[data-column='" + data['subCategories'][0]['parent_id'] + "'] td#subName ul").append("<li data-identify='" + data['subCategories'][i]['id'] + "'>" + data['subCategories'][i]['name'] + "</li>")*/

                }else{
                    $('.odd').hide();
                }

        }


    }
  //ajax fetch data
    let _token   = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url:'/dashboard/subject/ajax',
    type: 'get',
        data: {
        _token: _token,
    },
    success: function (data) {
        fetch(data.data);
    },
    error: function ($response) {
    }
});

  // category section
    const regSpecial = /[`@#$%^&*+=\[\]{}'"\\|<>\/~]/;

    $(".post-tags").on("keydown", function (event) {

        if (event.key == "Enter") {
            event.preventDefault();
            event.stopPropagation();

            addTags(event);
        }
    });

    $(".post-tags+i").on("click", addTags);

    $(".tag-item i").on("click", removeTag);

    function removeTag(event) {
        $(event.target).parent(".tag-item").remove();
    }

    function addTags(event) {
        if (
            $(".post-tags").val() == "" ||
            regSpecial.test($(".post-tags").val()) ||
            $(".post-tags").val().length > 255
        ) {
            event.preventDefault();
            $(".post-tags")
                .siblings(".errors")
                .text("* دسته وارد شده صحیح نمی باشد!");
        } else {
            $(".tags-container").append(
                `<a class="tag-item btn btn-danger">
      <i class="fa fa-close align-middle"></i>
      ${$(".post-tags").val()} <input type="hidden" name="tag[]" id="InputVal" value="  ${$(".post-tags").val()} "/>
  </a>`
            );


            $(".tag-item i").off("click", removeTag);

            $(".tag-item i").on("click", removeTag);

            $(".post-tags").val("");
            $(".post-tags").siblings(".errors").text("");

        }
    }
    // delete ajax
    $('body').on("click", "tbody tr .delete", function () {
        $('.project-list-header').html('');
        var id = $(this).data('id');
        var childId = $(this).data('subname');
        var elem=   $(this).parent().parent();
        elem.addClass('Text'+id+'');
        let _token   = $('meta[name="csrf-token"]').attr('content');
        swal({
            title: `برای حذف آیتم مطمئن هستید؟`,
            text: "در صورت حذف امکان بازگشت دیتا وجود ندارد",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax
                    ({
                        type: "get",
                        dataType: 'json',
                        url: `/dashboard/subject-delete`,
                        data: {_token: _token, id: id,childId:childId}
                    }).done(function (data) {

                         $('#categorySelect option[value='+id+']').remove();
                         $('#updateCategorySelect option[value='+id+']').remove();
                        $("[data-column="+id+"]").remove();


                        Swal.fire({
                            title: 'success',
                            text:  data.success,
                            icon: 'success',
                            confirmButtonText: 'Cool'
                        })
                    }).fail(function () {
                        console.log('Ajax Failed')
                    });
                }
            });

    })

    //edit data
    $('body').on('click','.edit', function (event) {
        $('.project-list-header').html('');
        $('#updateCard').show();
        $('#ajaxCard').hide();
        var childId = $(this).data('subname');
        var id = $(this).data('id');
        $('#id').val(id);
        $('.updateFormDiv').show();
        for(var j=0; j<2;j++){
            $(".update-tag-item i").click();
        }
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax
        ({
            type: "get",
            dataType: 'json',
            url: `/dashboard/subject-edit`,
            data: {_token: _token, id: id,childId:childId }
        }).done(function (data) {

                $("#updateCategorySelect").val(data['categories'].name);


            for(var i=0;i<data.subCat.length;i++){
                $(".update-tag-item i.update-icon").click();
                $(".update-tags-container").append(
                    `<a class="update-tag-item btn btn-danger" data-subid="${data.subCat[i].id}"><i class="fa fa-close align-middle update-icon" style="top:45%"></i>${data.subCat[i].name} </a>`)
            }
        }).fail(function () {
            console.log('Ajax Failed')
        });
    });
  $('#updateCategoryVal').val('');
    $('body').on('click', '#updateButton', function (event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
    });

    $('#closeBtnUpdate').click(function (event) {
        event.preventDefault();
        this.setAttribute('data-dismiss','modal');
        $('#updateError').html('');
        $('.project-list-header').html('');
        var InputVal = document.getElementsByName('tag[]');
        for (var j = 0; j < InputVal.length; j++) {
            $(".tag-item i").click();
            $(".update-tag-item .update-icon").click();
        }
    });

    $( '#updateButton').click( function (event) {
        event.preventDefault();
        event.stopPropagation();
        var id = $('#id').val();
        $('.project-list-header').html('');
        $('#updateError').html('');
        var parentName = $("#updateCategorySelect").val();
        var childName = $('#updateCategoryVal').val();
        var removeDataSubNamesId = $('#updateCategoryVal').attr('data-subnames');

        var BtnEdit = document.querySelector("[data-column='" + id + "'] .edit");
        var childId= BtnEdit.getAttribute('data-subname');
        var updateInputVal = document.getElementsByName('updateTag[]')
        for(var j=0; j<updateInputVal.length;j++){
            $(".update-tag-item i.update-icon").click();
        }
        $("[data-column="+id+"]").val(id);
        let _token   = $('meta[name="csrf-token"]').attr('content');
        const regSpecial = /[`@#$%^&*+=\[\]{}'"\\|<>\/~]/;

        if (
            $("#updateCategorySelect").text() == "" ||
            regSpecial.test($("#updateCategorySelect").text()) ||
            $("#updateCategorySelect").text().length > 255
        ) {
            event.preventDefault();
            $(".catError")
                .text("* دسته وارد شده صحیح نمی باشد!");
        }else
            {
                $.ajax
                ({
                    type: "get",
                    dataType: 'json',
                    url: `/dashboard/subject-update`,
                    data: {_token: _token, id: id, parentName: parentName, childName: childName, childId: childId,removeDataSubNamesId:removeDataSubNamesId}
                }).done(function (data) {

                    $("#updateCategorySelect").val('')
                    $('#updateCategoryVal').val('')
                    $(".updatename").val("");
                    $('#user-field').val('')
                    var removeDataSubNamesId = $('#updateCategoryVal').attr('data-subnames','');
                    if (data.data['flag']) {

                        if (data.data.hasOwnProperty('parentCat')) {
                            $('#categorySelect option[value=' + data.data['parentCat']['id'] + ']').remove();
                            var tdName = document.querySelector("[data-column='" + id + "'] td#name");
                            tdName.innerText = data.data['parentCat']['name'];
                            $('#categorySelect').append("<option value='" + data.data['parentCat']['id'] + "'>" + data.data['parentCat']['name'] + "</option>");
                        }
                        if (data.data.hasOwnProperty('childCat')) {

                            for (var i=0;i<data.data.childCat.length;i++) {
                                var tdName = document.querySelector("[data-subsubject='" + data.data.childCat[i].id + "'] ");
                                tdName.innerText = data.data.childCat[i].name;
                            }
                        }
                        $('.updateFormDiv').hide();
                        Swal.fire({
                            title: 'success!',
                            text: data.success,
                            icon: 'success',
                            confirmButtonText: 'Cool'
                        })
                        $('.project-list-header').html('<h4 style="color: green">آیتم باموفقیت آپدیت شد</h4>');
                    } else {
                        $('#updateError').html('<h4 style="color: red">'+data.errors+'</h4>');
                    }
                }).fail(function (data) {
                    Swal.fire({
                        title: 'error!',
                        text: 'Request failed',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })

                });
            }
    });

  //update section

  $(".update-post-tags").on("keydown", function (event) {
      if (event.key == "Enter") {
          event.preventDefault();
          event.stopPropagation();
          addUpdateTags(event);
      }
  });

  $(".update-post-tags+i.update-icon").on("click", addUpdateTags);

  $(".update-tag-item i.update-icon").on("click", removeUpdateTag);
let subIdArray=[];
  function removeUpdateTag(event) {

      let subId =$(event.target).parent(".update-tag-item").attr('data-subid');
        subIdArray.push(subId)
      $("#updateCategoryVal").attr('data-subnames',subIdArray)
      $(".update-tags-container").append(
          ` <input type="hidden" name="removetag[]" id="removeTag" value="  ${$(event.target).parent(".update-tag-item").text()} "/>`)
      $(event.target).parent(".update-tag-item").remove();
  }

  function addUpdateTags(event) {
      if (
          $(".update-post-tags").val() == "" ||
          regSpecial.test($(".update-post-tags").val()) ||
          $(".update-post-tags").val().length > 255
      ) {
          event.preventDefault();
          $(".update-post-tags")
              .siblings(".errors")
              .text("* دسته وارد شده صحیح نمی باشد!");
      } else {
          $(".update-tags-container").append(
              `<a class="update-tag-item btn btn-danger">
      <i class="fa fa-close align-middle update-icon" style="top:45%"></i>
      ${$(".update-post-tags").val()} <input type="hidden" name="updateTag[]" id="UpdateInputVal" value="  ${$(".update-post-tags").val()} "/>
  </a>`
          );

          $(".update-tag-item i.update-icon").off("click", removeUpdateTag);

          $(".update-tag-item i.update-icon").on("click", removeUpdateTag);

          $(".update-post-tags").val("");
          $(".update-post-tags").siblings(".errors").text("");

          var updateInputVal = document.getElementsByName('updateTag[]');
          var updateinputVal = ''
          var arr = [];
          for (var i = 0; i < updateInputVal.length; i++) {
              var updatecontent = updateInputVal[i].value;

              updateinputVal = updatecontent.trim();
              arr.push(updateinputVal);
              $('#updateCategoryVal').val('')
              $('#updateCategoryVal').val(arr);
          }

      }
  }
    //fetch category data

        function filterCat(data) {

            for (var i = 0; i < data['categories'].length; i++) {
                $('#categorySelect').append("<option value='" + data['categories'][i]['id'] + "'>" + data['categories'][i]['name'] + "</option>");
            }
        }

        $.ajax({
            url: "/dashboard/subject",
            type: 'get',
            data: {
                _token: _token,
            },
            success: function (data) {

                filterCat(data.data);
            },
            error: function ($response) {
            }
        });

    // update select ajax fetch
    function filterCategory(data) {

        for (var i = 0; i < data['categories'].length; i++) {
            $('#updateCategorySelect').append("<option value='" + data['categories'][i]['id'] + "'>" + data['categories'][i]['name'] + "</option>");
        }
    }

    $.ajax({
        url: "/dashboard/subject",
        type: 'get',
        data: {
            _token: _token,
        },
        success: function (data) {

            filterCategory(data.data);
        },
        error: function ($response) {
        }
    });
    $('#closeBtnAjax').click(function (event) {
        event.preventDefault();
        this.setAttribute('data-dismiss','modal');
        var InputVal = document.getElementsByName('tag[]');
        for (var j = 0; j < InputVal.length; j++) {
            $(".tag-item i").click();

        }
    });

    $('#addButton').click(function (){
        $('.project-list-header').html('');
        $('#addError').html('');
    })
    $('#ajaxAddButton').click(function (event) {
        $('.project-list-header').html('');
        $('#addError').html('');
        let _token = $('meta[name="csrf-token"]').attr('content');

         event.preventDefault();
        event.stopPropagation();
        this.setAttribute('data-dismiss','modal');
         event.stopImmediatePropagation();
        var InputVal = document.getElementsByName('tag[]');
        var inputVal = ''
        var arr = [];
        for (var i = 0; i < InputVal.length; i++) {
            var content = InputVal[i].value;

            inputVal = content.trim();
            arr.push(inputVal);
            $('#categoryVal').val('')
            $('#categoryVal').val(arr);
        }

        $("#name-error").text("* مقدار وارد شده صحیح نمی باشد!");
        $.ajax({
            url: "/dashboard/subjects/add",
            type: 'get',
            data: {
                parentId: $('#categorySelect').val(),
                name: $('#categoryVal').val(),
                _token: _token
            }
        }).done(function (data) {
            for (var j = 0; j < InputVal.length; j++) {
                $(".tag-item i").click();
            }
            $('#categorySelect').val('');
            $('#categoryVal').val('')
            $('#user-field').val('');

if(data.data['flag']) {
    if (data.arr) {
        for(var i=0;i< data.arr.length;i++) {
            $('#categorySelect').append("<option value='" + data.arr[i].id + "'>" + data.arr[i].name + "</option>");

            $('tbody').append("<tr style='width: 100%;' data-column='" + data.arr[i].id + "'><td class='table-img'><img src='images/p-13.jpg' alt></td><td id='name'>" + data.arr[i].name + "</td><td id='subName'></td><td><div><a data-id='" + data.arr[i].id + "' class='btn btn-primary shadow btn-xs sharp m-1 edit' id='edit'  data-toggle='modal' data-target='#modal_update_adduser'><i class='fa fa-pencil'></i></a><a data-id='" + data.arr[i].id + "' class='btn btn-danger shadow btn-xs sharp delete show_confirm m-1' data-toggle='tooltip' title='Delete'><i class='fa fa-trash'></i></a></div></td></tr>")
        }

    }

    if(data.arrChild){
      //  $("[data-column='" + data.arrChild[0][0].parent_id + "'] td#subName").append('<ul></ul>')
        for(var i=0;i<data.arrChild.length;i++) {
            $("[data-column='" + data.arrChild[i][0].parent_id + "'] td#subName ul").append("<li data-subsubject='"+data.arrChild[i][0].id+"'>" + data.arrChild[i][0].name + "</li>");
          /*   var tdSubName = document.querySelector("[data-identify='" + data.arrChild[i][0].id + "']");
            console.log(data.arrChild[i][0].id)
            console.log(tdSubName)*/
           /*  tdSubName.innerText = data.arrChild[i][0].name;*/
        }
    }
    $('.project-list-header').html('<h4 style="color: green">آیتم باموفقیت ثبت شد</h4>');
}else{
    $('#addError').html('<h4 style="color: red">'+data.errors+'</h4>');
}
            $('.alert').show();
            $('.alert').html(data.success);
            $('#addName').val("");
            $('#addEmail').val("");
            $('#addPassword').val("");
        }).fail(function (error) {
            $('.errors').html('');

        });
    })




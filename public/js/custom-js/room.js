$(document).ready(function(){
    $.noConflict();
    var RoomList = $('#RoomList').DataTable({
        dom:'CBrfltip',
        serverSide:true,
        processing:true,
        colReorder:true,
        stateSave:true,
        responsive:true,
        buttons:[
            {
                extend:'copy',
                text:'<button class="btn btn-primary"><i class="fa fa-copy"></i></button>',
                titleAttr:'Copy Items'
            },
            {
                extend:'excel',
                text:'<button class="btn btn-success"><i class="fa fa-table"></i></button>',
                titleAttr:'Export to Excel',
                filename:'Room_List',
            },
            {
                extend:'pdf',
                text:'<button class="btn bg-purple"><i class="fa-solid fa-file-pdf"></i></button>',
                titleAttr:'Export to Pdf',
                filename:'Room_List',
            },
            {
                extend:'csv',
                text:'<button class="btn btn-info"><i class="fas fa-file-csv"></i></button>',
                titleAttr:'Export to PDF',
                filename:'Room_List',
            },
            {
                text:'<button class="btn btn-dark"><i class="fa-solid fa-file"></i></button>',
                titleAttr:'Export To JSON',
                filename:'Room_List',
                action:function(e,dt,button,config){
                    var data = dt.buttons.exportData();
                    $.fn.dataTable.fileSave(
                        new Blob([JSON.stringify(data)])
                    );
                },
            },
        ],
        ajax:{
            url:'/room',
            type:'Get',
        },
        columns:
        [
            {data:'id',visible:false},
            {data:'HotelName'},
            {data:'RoomNo'},
            {data:'Floor'},
            {data:'Type'},
            {data:'Geyser', render:function(data, type,row){
                return data == 1?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';
            }},
            {data:'AC', render:function(data, type,row){
                return data == 1?'<i class="fa fa-check text-success"></i>':'<i class="fa-solid fa-xmark text-danger"></i>';
            }},
            {data:'Balcony', render:function(data, type,row){
                return data == 1?'<i class="fa fa-check text-success"></i>':'<i class="fa-solid fa-xmark text-danger"></i>';
            }},
            {data:'Internet', render:function(data, type,row){
                return data == 1?'<i class="fa fa-check text-success"></i>':'<i class="fa-solid fa-xmark text-danger"></i>';
            }},
            {data:'TV', render:function(data, type,row){
                return data == 1? '<i class="fa fa-check text-success"></i>':'<i class="fa-solid fa-xmark text-danger"></i>';
            }},
            {data:'Price'},
            {data:'action'}
        ]
    });

    $('#ResetBtnForm').on('click',function(e){
        e.preventDefault();
        $('#NewRoomFrom')[0].reset();
    });

    $('body').on('click','#ViewBtn',function(e){
        e.preventDefault();
        var ID = $(this).data('id');
        console.log(ID);
        $.ajax({
            type:'GET',
            url:'/room/'+ID,
            success:function(data){

                $('#ViewType').text(data['Type']);
                $('#ViewFloor').html(data['Floor']);

                $('#ViewHotel').text(data['HotelName']);
                
                data['Geyser']  == '1'? $('#ViewGeyser').html('<i class="fa fa-check text-primary"></i>'):$('#ViewGeyser').html('<i class="fa fa-times text-danger"></i>');             

                $('#ShowRoomModal').modal('show');
            }

        });
    });
    $('#SubmitBtn').on('click',function(e){
        e.preventDefault();
        
        $.ajax({
            type:'POST',
            url:'/room',
            data: $('#NewRoomFrom').serializeArray(),
            success:function(data){
                $('#NewRoomFrom')[0].reset();
                $('#NewRoomModal').modal('hide');
                 Swal.fire(
                  'Success!',
                  data,
                  'success'
                )
                RoomList.draw(false);
            },
            error:function(data){
                console.log('Error while adding new hotel' + data);
            },
        });
    });

    $('body').on('click','#DeleteBtn',function(e){
        e.preventDefault();
        // console.log($(this).val());
        var ID = $(this).data('id');
        console.log(ID);
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to delete this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                type:'GET',
                url:'/room/delete/'+ID,
                success:function(data){
                   Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    );
                },
                error:function(data){
                    Swal.fire(
                      'Error!',
                      'Delete failed !',
                      'error'
                    );

                    console.log(data);
                },
            });

            
         }
        });
    });

    $('#DeleteAllBtn').on('click',function(e){
        e.preventDefault();
         Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to DeleteAll this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, DeleteAll it!'

            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type:'GET',
                        url:'/room/delete',
                        success:function(data){
                        Swal.fire(
                            'DeleteAll!',
                            'Your file has been DeleteAll.',
                            'success'
                            );
                        },
                        error:function(data){
                            Swal.fire(
                            'Error!',
                            'DeleteAll failed !',
                            'error'
                            );

                            console.log(data);
                        },
                    });

                    
                }
            });
    });

});
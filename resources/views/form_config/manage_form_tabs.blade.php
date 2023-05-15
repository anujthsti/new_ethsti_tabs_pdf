<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Manage Form Tabs";
    // variables for section buttons bar
    $createBtnTitle = "Create Form Tabs";
    $createBtnLink = route('add_form_tab');
?>
<!-- common sections variables end -->

<x-app-layout>
    <!-- section header title html -->
    @include('layouts/header_title')
    
    <div class="container mt-2">
        <!-- section buttons bar html -->
        @include('layouts/buttons_bar')
        <!-- success message alert html start -->
        @if ($message = Session::get('success'))
            <!-- include success message common view -->
            @include('layouts/success_message')
        @endif
        <!-- success message alert html end -->
        <!-- table html start -->
        
        <table class="table table-bordered dataTable">
            <!-- table header html start -->
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>Tab Title</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <!-- table header html end -->
            <tbody id="sortableContents">
                <!-- table rows for loop start -->
                @foreach ($formTabs as $tab)
                    <?php
                    // encode id
                    $encId = Helper::encodeId($tab->id);
                    ?>
                    <tr data-id="{{ $tab->id }}" class="sortableRow">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tab->tab_title }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('edit_form_tab',$encId) }}"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-danger" href="{{ route('delete_form_tab',$encId) }}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
                <!-- table rows for loop end -->
                
            </tbody>
        </table>
        <!-- table html end -->
        <?php /* ?>
        {!! $rn_nos->links() !!}
        <?php */ ?>
    </div>

<script>
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $( "#sortableContents" ).sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function() {
              updateSorting();
          }
        });

        function updateSorting() {
            //alert("sorting updated.");
            
            var order = [];
            var token = $('meta[name="csrf-token"]').attr('content');
            $('tr.sortableRow').each(function(index,element) {
                order.push({
                    id: $(this).attr('data-id')
                });
            });

            $.ajax({
                    type: "POST", 
                    dataType: "json", 
                    url: "{{ route('update_form_tabs_sorting') }}",
                    data: {
                            order: order,
                            _token: token
                        },
                    success: function(response) {
                        let status = response['status'];
                        let msg = response['msg'];
                        alert(msg);
                    }
            });
          
        }
      });
</script>
<script type="text/javascript">  
    /*
    $( ".row_position" ).sortable({  
        delay: 150,  
        stop: function() {  
            var selectedData = new Array();  
            $('.row_position>tr').each(function() {  
                selectedData.push($(this).attr("id"));  
            });  
            updateOrder(selectedData);  
        }  
    });  
  
    function updateOrder(data) {  
        alert('reorder successfull.');
        break;
        $.ajax({  
            url:"ajaxPro.php",  
            type:'post',  
            data:{position:data},  
            success:function(){  
                alert('your change successfully saved');  
            }  
        });
        
    }  
    */
</script>  
</x-app-layout>    
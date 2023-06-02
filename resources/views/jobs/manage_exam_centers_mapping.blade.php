<?php
$title = "Manage Exam centers mapping";
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($title) }}
        </h2>
    </x-slot>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="text-left">
                    <a class="btn btn-primary" href="{{ route('add_exam_center_mapping') }}"> Add exam centers mapping</a>
                </div>
            </div>
        </div>
        </br>
        
        <table class="table table-bordered dataTable">
            <!-- table header html start -->
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>RN No.</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <!-- table header html end -->
            <tbody>
                <!-- table rows for loop start -->
                @foreach ($examCentersMapp as $examCenter)
                    <?php
                    $subUrl = "/".$examCenter['id']."/".$examCenter['job_id'];//Helper::encodeId($roNo['job_id']);
                    ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $examCenter['rn_no'] }}</td>
                        <td>
                            <!-- action html start -->
                            <a class="btn btn-primary" href="<?php echo route('edit_exam_center_mapping').$subUrl; ?>"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-danger" href="<?php echo route('delete_exam_center_mapping').$subUrl; ?>"><i class="fa fa-trash"></i></a>
                            <?php /** */ ?>
                            <a class="btn btn-primary" href="<?php echo route('exam_interview_shift')."/".$examCenter['job_id']; ?>">Shift</a>
                            <?php /**/ ?>
                            <!-- action html end -->
                        </td>
                    </tr>
                @endforeach
                <!-- table rows for loop end -->
                
            </tbody>
        </table>
    </div>

</x-app-layout>    
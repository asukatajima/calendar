@extends('layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css"href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@endsection    
@section('script')    
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/lang/ja.js"></script>
<script type='text/javascript'>
$(document).ready(function() {
        $('#calendar').fullCalendar({
          
          header: {
            left: 'prev today  prevYear,nextYear',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,list next'
        },
        
        height: 620, // 高さ
        timeFormat: 'h:mm', // 時間表示フォーマット
        axisFormat: 'H:mm',
    	timeFormat: {
		agenda: 'H:mm{ - H:mm}'
    	},
        timezone: 'Asia/Tokyo', // タイムゾーン設定
        eventLimit: true, // イベント増えた時にリンクボタン表示
        editable: true, // 編集可能設定
        slotEventOverlap: false, // イベントの見た目を重ねて表示
        selectable: true, // カレンダー空白部分のドラッグ可能
        selectHelper: true, // 範囲設定できます
        selectMinDistance: 1,
        droppable: true,// イベントをドラッグできるかどうか
        
          select: function(start, end) {
           var title = prompt(start + " 予定を入力してください:");
           
           $('#startDay').val(start);
               var eventData;
           if (title) {
                eventData = {
                            title: title,
                            start: start,
                            end: end
           };
        $('#calendar').fullCalendar('renderEvent', eventData, true); 
           }
        $('#calendar').fullCalendar('unselect');
           },
        
           
           eventClick:function(event, jsEvent){
		    	var title = prompt('予定を変更してください:', event.title);
		    	var eventData;
			    if(title!=""){
				  event.title = title;
			  	$('#calendar').fullCalendar('updateEvent', event); //イベント（予定）の修正
		      	}else{
			  	$('#calendar').fullCalendar("removeEvents", event.id); //イベント（予定）の削除				
		    	}
        },
        
        
            
            
        eventClick: function(calEvent, jsEvent, view) {
        $('#event_id').val(calEvent._id);
        $('#startdt').val(moment(calEvent.start).format('YYYY-MM-DD HH:mm:ss'));
        $('#enddt').val(moment(calEvent.end).format('YYYY-MM-DD HH:mm:ss'));
        $('#editModal').modal();
    },
    
     $('#event_update').click(function(e) {
        e.preventDefault();
        var data = {
            _token: '{{ csrf_token() }}',
            event_id: $('#event_id').val(),
            start_time: $('#startdt').val(),
            finish_time: $('#enddt').val(),
        };

        $.post('{{ route('events.ajax_update') }}', data, function( result ) {
            $('#calendar').fullCalendar('removeEvents', $('#event_id').val());

            $('#calendar').fullCalendar('renderEvent', {
                title: result.event.client.content,
                start: result.event.startdt,
                end: result.event.enddt
            }, true);

            $('#editModal').modal('hide');
        });
        
     });
  
});
      </script>
      @endsection
  @section('content')
    <div id="calendar">
    </div>
       <Form action="{{route('events.store')}}" method="post">
           {{ csrf_field() }}
                <div class="form-group">
                    {!! Form::label('startdt', '開始日:') !!}  
                    {!! Form::text('startdt', null, ['class' => 'form-control']) !!}
                </div>
                 <div class="form-group">
                    {!! Form::label('enddt', '終了日:') !!}
                    {!! Form::text('enddt', null, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('content', 'イベント:') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                </div>
        
                {!! Form::submit('投稿', ['class' => 'btn btn-primary']) !!}
        
            </Form>
            
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" name="event_id" id="event_id" value="" />
            
            <div class="modal-body">
                <h4>Edit Appointment</h4>

                Start time:
                <br />
                <input type="text" class="form-control" name="startdt" id="startdt">

                End time:
                <br />
                <input type="text" class="form-control" name="enddt" id="enddt">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="button" class="btn btn-primary" id="event_update" value="Save">
            </div>
        </div>
    </div>
</div>
    @endsection
    
<?php
use Illuminate\Support\Facades\Session;
Session::start();
?>
@extends('layouts.frontend.dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-lg-3 theiaStickySidebar">

                    <div class="card booking-card">
                        <div class="card-header">
                            <h4 class="card-title">All Questions</h4>
                        </div>
                        <div class="card-body">
                            <div class="row pagination">
                                <input type="hidden" value="{{ $i = 1 }}">
                                @foreach ($questions_answers as $question_answer)
                                    @if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id == $question_answer['exam_id'])
                                        <div class="col-3">
                                            <div id="check-selected-question-{{ $question_answer['id'] }}"
                                                key-id="{{ $i }}">
                                                <a role="button" class="btn btn-success visit-to-question"
                                                    style="width:50px" question-id="{{ $question_answer['id'] }}"
                                                    href="javascript:void(0)">{{ $i++ }}</a>
                                            </div>
                                        </div>
                                        @if ($i % 4 == 0)<br><br>@endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="pagination row">
                                <div class="col-8 checktime">
                                    <p id="countdown" class="timer" exam-id="{{ $exam_id }}"
                                        time="{{ $exam['time'] }}"></p>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary finish-exam" subject-id={{ $subject_id }}
                                        exam-id={{ $exam_id }}>Submit</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-md-7 col-lg-9">

                    <div class="card">
                        <div class="card-body append_answer_question">
                            <input type="hidden" value="{{ $i = 1 }}">
                            @foreach ($questions_answers as $question_answer)
                                @if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id == $question_answer['exam_id'])
                                    <div class="info-widget">
                                        Question {{ $i++ }} {!! $question_answer['question'] !!}
                                        @if (!empty($question_answer['image']))
                                            <img src="{{ $question_answer['image'] }}" width="200px"
                                                height="200px"><br><br>
                                        @endif
                                        Select one:
                                        @foreach ($question_answer['answer'] as $answer)
                                            <h5><input type="radio" value="{{ $answer['id'] }}" class="sub_answer"
                                                    name="{{ $question_answer['id'] }}"
                                                    question-id="{{ $question_answer['id'] }}"
                                                    answer-id="{{ $answer['id'] }}">&nbsp;&nbsp;{{ $answer['answer'] }}
                                            </h5>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach



                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')


    <script>
            var question_id = $(this).attr('question-id');
            localStorage.setItem('sub_answer', $('.sub_answer').prop('checked'));

        if (localStorage.getItem("seconds")) {
            var seconds = localStorage.getItem("seconds");
        } else {
            var seconds = 60 * parseInt($('#countdown').attr('time'));
        }
        var exam_id = $('#countdown').attr('exam-id');
        // var seconds = initialTime;

        function timer() {
            var days = Math.floor(seconds / 24 / 60 / 60);
            var hoursLeft = Math.floor((seconds) - (days * 86400));
            var hours = Math.floor(hoursLeft / 3600);
            var minutesLeft = Math.floor((hoursLeft) - (hours * 3600));
            var minutes = Math.floor(minutesLeft / 60);
            var remainingSeconds = seconds % 60;
            if (remainingSeconds < 10) {
                $('.checktime').html(
                    '<p id="countdown" class="timer btn btn-error"></p>'
                );
                remainingSeconds = "0" + remainingSeconds;
            }
            document.getElementById('countdown').innerHTML = days + "d " + hours + "h " + minutes + "m " +
                remainingSeconds + "s";
            if (seconds == 0) {
                // clearInterval(countdownTimer);
                var subject_id = $('.finish-exam').attr('subject-id');
                allanswers = [];
                $('.sub_answer:checked').each(function() {
                    allanswers.push($(this).attr('answer-id'));
                });
                var all = allanswers.join(",");
                $.ajax({
                    url: '/check-result-answer',
                    type: 'POST',
                    data: {
                        answer_ids: all,
                        exam_id: exam_id,
                        subject_id: subject_id
                    },
                    success: function(resp) {
                        if (resp['status'] == true) {
                            window.location.href = "/result/exam/" + exam_id;
                        }
                    },
                    error: function(err) {
                        alert('ERROR');
                    }
                });
            } else {

                seconds--;
                localStorage.setItem("seconds", seconds);
                setTimeout("timer()", 1000);
            }
        }
        setTimeout("timer()", 1000);

    </script>

@endpush

@extends('master.grids')

@section('content')
<section class="content-header">
    <h1><i class="fa fa-question fa-sm"></i> Help</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/app')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active">Help</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-body">
                  <div class="col-md-8">
                    <h4 class="box-title">Where to start</h4>
                    <ul>
                        <li>We highly recommend that you read Brian Tracy's books "Eat that frog" and "The Power of Habit: 7 Steps to Successful Habits"</li>
                        <li>
                            <a href="https://www.youtube.com/watch?v=670Zm15WOK4" target="_blank">Watch this video on Personal Time Management</a>
                        </li>
                        <li>Start setting your goals daily and develop a habit of it (do it for 21 days)</li>
                    </ul>
                    <h4 class="box-title">Set you #1 Goal and start accomplishing it</h4>
                    <ul>
                        <li>Take your time to come up with your top goals</li>
                        <li>Organize your top goals according to priority and importance (urgency)</li>
                        <li>Choose the goal with priority A and urgency 1 and start working on developing a plan of action</li>
                        <li>After listing every tasks you need to complete to achieve the goal start working on your top priority tasks</li>
                        <li>Every morning after you set your daily goals start immediately working on your Goal #1 - Eating that frog</li>
                    </ul>
                    <h4 class="box-title">21 Rules of "Eat that frog"</h4>
                    <ol>
                          <li>Set the table and clearly write your goals and objectives.</li>
                          <li>Plan every day in advance by thinking on paper.</li>
                          <li>Apply the 80/20 rule to everything and focus on the top 20%.</li>
                          <li>Consider the consequences of not doing your biggest projects.</li>
                          <li>Practice the ABCDE method of prioritizing your tasks.</li>
                          <li>Focus on key result areas. The areas that are most important in your job or career.</li>
                          <li>Practice the law of forced efficiency.</li>
                          <li>Prepare thoroughly before you begin.</li>
                          <li>Upgrade your skills.</li>
                          <li>Leverage your special talents and give it your best.</li>
                          <li>Identify the bottlenecks that are holding you back and resolve them.</li>
                          <li>Take it one step at a time.</li>
                          <li>Put the pressure on yourself.</li>
                          <li>Maximize your personal powers. Get rest and work in your optimal productive hours.</li>
                          <li>Motivate yourself into action by being optimistic.</li>
                          <li>Practice procrastination on items that are low value.</li>
                          <li>Do the most difficult task first.</li>
                          <li>Slice and dice the task into smaller pieces.</li>
                          <li>Organize your day into larger groups of productive time.</li>
                          <li>Develop a sense of urgency.</li>
                          <li>Single handle every task, set priorities and complete before moving on</li>
                    </ol>
                    <h4 class="box-title">9 habits of highly successful people, by B.Tracy</h4>
                    <ol>
                        <li>Self-Discipline - the ability to make yourself do what you should do, when you should do it, whether you feel like it or not</li>
                        <li>Become a Lifelong Optimist - You become what you think about most of the time</li>
                        <li>Think About Your Goals - Develop a habit of setting goals and making plans for their accomplishment</li>
                        <li>Set Your Goals Each Day</li>
                        <li>Identify Key Professional Skills - Develop the habit of continually identifying and working on your weakest key skill</li>
                        <li>Commit To Lifelong Learning</li>
                        <li>What You See Is What You Will Be</li>
                        <li>Be Around the Right People</li>
                        <li>Take Initiative</li>
                    </ol>
                  </div>
                  <div class="col-md-4">
                    <h4 class="box-title">Using datepicker</h4>
                    <p>To switch quickly between months or years click on the year at the top.</p>
                    <img src="/assets/images/1.png" alt="Datepicker" style="max-width: 90%;"><br>
                    <img src="/assets/images/2.png" alt="Switch between years or months" style="max-width: 90%;">
                  </div>  
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('custom-grid')
    
@stop

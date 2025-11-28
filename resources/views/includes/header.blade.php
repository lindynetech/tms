@if (Auth::check())
<header class="main-header">
  <!-- Logo -->
  <a href="{{url('/app')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="/landing/images/favicon.png" style="max-height: 27px;" /></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="/landing/images/favicon.png" style="max-height: 27px;" /></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle sidebarswitch" data-toggle="offcanvas" role="button">
      <!-- <i class="fa fa-arrow-left"></i><i class="fa fa-arrow-right"></i>
       -->
       <i class="fa fa-bars"></i>
    </a>
    <span class="hidden-xs topheadermenu">
    <a href="/app" class="sidebar-toggle" style="margin-left: 30px;" role="button">
       <i class="fa fa-th-large"></i> Dashboard
    </a>
    <a href="/dailygoals" class="sidebar-toggle" role="button">
       <i class="fa fa-tasks"></i> Daily Goals
    </a>
    <a href="/goals/eatfrog" class="sidebar-toggle" role="button">
       <i class="fa fa-frog"></i> Goal #1
    </a>
    <a href="/goals" class="sidebar-toggle" role="button">
       <i class="fa fa-tasks"></i> All Goals
    </a>
    <a href="/habits" class="sidebar-toggle" role="button">
       <i class="fa fa-list"></i> Habits
    </a>
    <a href="/mindstorm" class="sidebar-toggle" role="button">
       <i class="fa fa-lightbulb"></i> Mindstorming
    </a>
    <a href="/readinglist" class="sidebar-toggle" role="button">
       <i class="fa fa-book"></i> Reading List
    </a>
    </span>
    <!-- <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><i class="fa fa-arrow-left"></i>
      <i class="fa fa-arrow-right"></i>
      <span class="sr-only">Toggle navigation</span>
    </a> -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-check"></i>
            <span class="hidden-xs"><b>Checklist</b></span>
          </a>
          <ul class="dropdown-menu" style="width: 290px !important;">
            <li class="user-footer">
              <div class="pull-left">
                <ul class="bulletless">
                  <li><span class="help-tooltip" id="21rules"><i class="fa fa-xs fa-check"></i> 21 Rules</span></li>
                  <li><span class="help-tooltip" id="typesgoals"><i class="fa fa-xs fa-check"></i> 3 Types of Goals</span></li>
                  <li><span class="help-tooltip" id="smart"><i class="fa fa-xs fa-check"></i> S.M.A.R.T Goals</span></li>
                  <li><span class="help-tooltip" id="abcde"><i class="fa fa-xs fa-check"></i> ABCDE Method</span></li>
                  <li><span class="help-tooltip" id="8020rule"><i class="fa fa-xs fa-check"></i> 80/20 Rule</span></li>
                  <li>
                    <span class="help-tooltip" id="selfdisc"><i class="fa fa-xs fa-check"></i> Self-Discipline</span>
                  </li>
                  <li>
                    <span class="help-tooltip" id="senseurgency"><i class="fa fa-xs fa-check"></i> Sense Of Urgency</span>
                  </li>
                  <li><span class="help-tooltip" id="planningtips"><i class="fa fa-xs fa-check"></i> Planning</span></li>
                  <li>
                    <span class="help-tooltip" id="chunkstime"><i class="fa fa-xs fa-check"></i> Chunks Of Time</span>
                  </li>
                  <li>
                    <span class="help-tooltip" id="lawforced"><i class="fa fa-xs fa-check"></i> Law Of Forced Efficiency</span>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </li>
         <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-calendar-alt"></i>
            <span class="hidden-xs"><b><?php echo date("Y-m-d"); ?></b></span>
          </a>
          <ul class="dropdown-menu" style="width: 220px !important;">
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-right">
              <div id="calendar"></div>
              </div>
            </li>
          </ul>
        </li>
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-user-cog"></i>
            @if (Auth::check())
            <span class="hidden-xs"><b>{{auth()->user()->name}}</b></span>
            @endif
          </a>
          <ul class="dropdown-menu" style="width: 190px !important;">
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="">
              <a href="{{url('/profile')}}" class="btn btn-primary"><i class="fa fa-cogs"></i> My Account</a>
                <a href="{{url('/logout')}}" class="btn btn-primary" style="margin-top: 5px;"><i class="fa fa-sign-out-alt"></i> Logout</a>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
          <!-- <a href="#" data-toggle="control-sidebar"><i class="fa fa-cog"></i></a> -->
        </li>
      </ul>
    </div>
  </nav>
</header>
@endif
<div id="21rulescontent" style="display: none;">
    <p><b>21 Rules of Time Management</b></p>
    <hr>
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
</div>

<div id="smartcontent" style="display: none;">
    <p><b>S.M.A.R.T. Goals</b></p>
    <hr>
    <ul>
       <li><b>S</b> - Specific</li>
       <li><b>M</b> - Measurable</li>
       <li><b>A</b> - Achievable</li>
       <li><b>R</b> - Relevant</li>
       <li><b>T</b> - Time-Bound</li>
     </ul>
</div>

<div id="typesgoalscontent" style="display: none;">
    <p><b>3 Types of Goals</b></p>
    <hr>
    <ul>
       <li><b>Personal and Family Goals</b> - Reasons why you alive, what you want to accomplish for yourself and your family</li>
       <li><b>Business, Career, Financial, Material Goals</b> - What is it that you want to accomplish in the exterior world</li>
       <li><b>Self-Development Goals</b> - Your ability, your willingness in developing yourself is the key in accomplishing everything else</li>
     </ul>
</div>

<div id="abcdecontent" style="display: none;">
    <p><b>ABCDE Method of Setting Priorities for Tasks</b></p>
    <hr>
    <ul>
       <li><b>A</b> - Must do</li>
       <li><b>B</b> - Should do</li>
       <li><b>C</b> - Nice to do, but if all A's and B's done</li>
       <li><b>D</b> - Delegate</li>
       <li><b>E</b> - Eliminate</li>
     </ul>
     <p><b>6-step method</b></p>
     <ol>
       <li>Choose your goals</li>
       <li>Set priorities</li>
       <li>Choose your activities</li>
       <li>Set your activities' priorities</li>
       <li>Schedule</li>
       <li>Implement</li>
     </ol>
</div>

<div id="8020rulecontent" style="display: none;">
    <p><b>80/20 Rule - Paretto Principle</b></p>
    <hr>
    <p>80% of value of what you do will be contained in 20% of what you do</p>
    <ul>
      <li>Make a list of 10 goals, 2 top of them will be worth all of the others put together</li>
      <li>Resist the temptation to clear up small things first</li>
      <li>Highly effective people work on a vital few versus trivial many</li>
      <li>Ineffective people work on trivial many that are fun, easy, irrelevant, they keep putting off 
            and delaying working on their major tasks</li>
    </ul>
    <p>Key to success is always asking:</p> 
    <ul>
         <li>What is most valuable use of my time (right now)?</li>
         <li>Is this the most important thing I can be doing?</li>
         <li>Is this task in the top 20 percent of my activities or in the bottom 80 percent?</li>
       </ul>   

</div>
<div id="planningtipscontent" style="display: none;">
    <p><b>Planning</b></p>
    <hr>
    <p>Plan every day in advance</p>
    <p>Think on paper - write all your goals and tasks</p>
    <p><b>The ability to set goals and to create tasks for their accomplishment is the master skill of success</b></p>
    <p>If you don't have clear goals for you life you are condemened to work for those who do</p>
    <p><b>5 P's of planning:</b> Proper Prior Planning Prevents Poor Performance</p>
    <p>NASA Rule #15: A review of most failed project problems indicates that the disasters
were well-planned to happen from the start. The seeds of problems
are laid down early. <strong>Initial planning is the most vital part of a project</strong></p>
</div>

<div id="senseurgencycontent" style="display: none;">
    <p><b>Develop a sense of Urgency</b></p>
    <hr>
    <ul>
       <li>Make a habit of moving fast on your key tasks</li>
       <li>Highly-effective people launch quickly and strongly toward their goals and objectives</li>
       <li>When you regularly take continuous action toward your most important goals, you activate the Momentum Principle of success - although it may take tremendous amounts of energy to overcome inertia and get 
        started initially, it then takes far less energy to keep going</li>
       <li>Repeat the words Do it now! Do it now! Do it now! over and over to yourself</li>
     </ul>
</div>

<div id="chunkstimecontent" style="display: none;">
    <p><b>Chunks Of Time</b></p>
    <hr>
    <ul>
       <li>Chunks of time are 60-90 minute periods of time when you feel most productive</li>
       <li>Highly successful people develop a habit of cutting out of blocks of time when they can work without interruptions</li>
       <li>Organize your days around large blocks of time where you can concentrate for extended periods on your most important tasks</li>
       <li>Make work appointments with yourself and then discipline yourself to keep them</li>
     </ul>
</div>

<div id="lawforcedcontent" style="display: none;">
    <p><b>Law Of Forced Efficiency</b></p>
    <hr>
    <ul>
       <li>There is never enough time to do everything, but there is always enough time to do the most important thing</li>
       <li>There will never be enough time to do everything you have to do</li>
     </ul>
</div>
<div id="selfdisccontent" style="display: none;">
    <p><b>Self-Discipline</b></p>
    <hr>
    <ul>
       <li>The most important habit you can develop for success, achievement and happiness is the habit of self-discipline</li>
       <li>Self-discipline is the ability to make yourself do what you should do, when you should do it, whether you feel like it or not</li>
       <li>Key to time management is self-discipline</li>
     </ul>
</div>

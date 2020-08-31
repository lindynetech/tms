/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

 /**
  * Commented out all removed/unused components
  */

$(function () {

  "use strict";

  //Make the dashboard widgets sortable Using jquery UI
  $(".connectedSortable").sortable({
    placeholder: "sort-highlight",
    connectWith: ".connectedSortable",
    handle: ".box-header, .nav-tabs",
    forcePlaceholderSize: true,
    zIndex: 999999
  });
  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

  //jQuery UI sortable for the todo list
/*  $(".todo-list").sortable({
    placeholder: "sort-highlight",
    handle: ".text",
    forcePlaceholderSize: true,
    zIndex: 999999
  });*/

  //The Calender
  $("#calendar").datepicker(
    { todayHighlight: true}
    );

/* Tooltips */

  new jBox('Tooltip', {
    attach: '#dailygoalstp',
    theme: 'TooltipBorderSmallGrey',
    width: 480,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#dailygoalstpcontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#vendorstp',
    theme: 'TooltipBorderSmallGrey',
    width: 400,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#vendorstpcontent'),
    animation: 'slide'
  });
/*
  new jBox('Tooltip', {
    attach: '#dailygoalstp',
    theme: 'TooltipBorderSmallGrey',
    width: 400,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#dailygoalstpcontent'),
    animation: 'slide'
  });*/

  new jBox('Tooltip', {
    attach: '#todotp',
    theme: 'TooltipBorderSmallGrey',
    width: 400,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#todotpcontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#eatthatfrogtp',
    theme: 'TooltipBorderSmallGrey',
    width: 400,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#eatthatfrogtpcontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#uncompletefrogtp',
    theme: 'TooltipBorderSmallGrey',
    width: 400,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#uncompletefrogtpcontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#goalstp',
    theme: 'TooltipBorderSmallGrey',
    width: 500,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#goalstpcontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#habitstp',
    theme: 'TooltipBorderSmallGrey',
    width: 600,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#habitstpcontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#mindstormtp',
    theme: 'TooltipBorderSmallGrey',
    width: 400,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#mindstormtpcontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#readinglisttp',
    theme: 'TooltipBorderSmallGrey',
    width: 450,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#readinglisttpcontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#taskstp',
    theme: 'TooltipBorderSmallGrey',
    width: 500,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#taskstpcontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#21rules',
    theme: 'TooltipBorderSmallGrey',
    width: 600,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#21rulescontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#smart',
    theme: 'TooltipBorderSmallGrey',
    width: 250,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#smartcontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#abcde',
    theme: 'TooltipBorderSmallGrey',
    width: 450,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#abcdecontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#8020rule',
    theme: 'TooltipBorderSmallGrey',
    width: 450,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#8020rulecontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#billingtp',
    theme: 'TooltipBorderSmallGrey',
    width: 450,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#billingtpcontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#senseurgency',
    theme: 'TooltipBorderSmallGrey',
    width: 450,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#senseurgencycontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#planningtips',
    theme: 'TooltipBorderSmallGrey',
    width: 450,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#planningtipscontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#chunkstime',
    theme: 'TooltipBorderSmallGrey',
    width: 450,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#chunkstimecontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#lawforced',
    theme: 'TooltipBorderSmallGrey',
    width: 450,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#lawforcedcontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#typesgoals',
    theme: 'TooltipBorderSmallGrey',
    width: 450,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#typesgoalscontent'),
    animation: 'slide'
  });

  new jBox('Tooltip', {
    attach: '#selfdisc',
    theme: 'TooltipBorderSmallGrey',
    width: 450,
    position: {
      x: 'left',
      y: 'center'
    },
    outside: 'x',
    pointer: 'top:5',
    content: $('#selfdisccontent'),
    animation: 'slide'
  });

});

// FullCalendarを利用する際に必要
// import { Calendar } from '@fullcalendar/core';
// import interactionPlugin from '@fullcalendar/interaction';
// import dayGridPlugin from '@fullcalendar/daygrid';
// import timeGridPlugin from '@fullcalendar/timegrid';
// import listPlugin from '@fullcalendar/list';

// document.addEventListener('DOMContentLoaded', function() {
//   const calendarEl = document.getElementById('calendar');

//   if (!calendarEl) {
//     return;
//   }

//   const events = JSON.parse(calendarEl.dataset.events); // data-eventsの値を取得
//   const today = new Date(); // 今日の日付を取得
//   const calendar = new Calendar(calendarEl, {
//     plugins: [ interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin ],
//     headerToolbar: {
//       left: 'prev,next today',
//       center: 'title',
//       right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
//     },
//     locale: 'ja',
//     initialDate: today,
//     navLinks: true, // can click day/week names to navigate views
//     editable: true,
//     dayMaxEvents: true, // allow "more" link when too many events
//     events,
//   });

//   calendar.render();
// });
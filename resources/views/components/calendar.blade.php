<script>
  // 関数外での変数定義はグローバル変数という。ここで定義されたものは関数で引数として()内に書かなくても使える
  // 例：　function showCalendar()のyearとmonthを引数として書かなくてもJavaScriptでは問題はない
const weeks = ['月', '火', '水', '木', '金', '土', '日']
const date  = new Date()
let year    = date.getFullYear()
let month   = date.getMonth() + 1

// config内に各種設定値を書くと便利
const config = {
  show: 1,
  // 1年分のカレンダーを表示するためのもの。下記のfunction内でmaxYearSpanを利用したコード書く必要あり
  maxYearSpan: 1,
}


const events = {!! $events !!};
// console.log(events); // デバッグ用にeventsをコンソールに出力

// 関数内での定義はローカル変数であるため、他の関数内で同じ名前で変数や定数の定義をしても別物として認識される
function showCalendar(year, month, events) {
  for ( i = 0; i < config.show; i++) {
    // createCalendarでinnerHTMLを使用しないのはカレンダーを表示する数を調整するのに便利だから
    const calendarHtml = createCalendar(year, month, events)
    // ここからDOM操作
    const sec = document.createElement('section')
    sec.innerHTML = calendarHtml
    document.querySelector('#calendar').appendChild(sec)
    month++
    if (month > 12) {
      year++
      month = 1
    }
  }
}

function createCalendar(year, month, events) {
  // console.log(Array.isArray(events)); // true または false を確認  falseの場合は取得したデータが期待通りに配列に変換されていない可能性がある

  // ()内の最後を1にすることで1日になる
  const startDate = new Date(year, month - 1, 1) // 月の最初の日を取得
  // ()内の最後を0にすることで最後の日が取得できる
  const endDate = new Date(year, month,  0) // 月の最後の日を取得
  const endDayCount = endDate.getDate() // 月の末日
  const lastMonthEndDate = new Date(year, month - 1, 0) // 前月の最後の日の情報
  const lastMonthendDayCount = lastMonthEndDate.getDate() // 前月の末日
  const startDay = startDate.getDay() - 1 // 月の最初の日の曜日を取得
  
  // 今日の日付
  const todayDate = new Date();
  // 日付
  const tDate = todayDate.getDate();
  const tMonth = todayDate.getMonth() + 1;
  const tYear = todayDate.getFullYear();
  let dayCount = 1 // 日にちのカウント
  let calendarHtml = '' // HTMLを組み立てる変数

  
  calendarHtml += '<p class="text-base">' + year  + ' / ' + '<span class="text-xl">' + month + '</span></p>'
  calendarHtml += '<table class="w-full">'
  
  // 曜日の行を作成
  calendarHtml += '<tr class="text-center">'
  for (let i = 0; i < weeks.length; i++) {
    if (i == 6){
      calendarHtml += '<td style = "color: red;">' + weeks[i] + '</td>'
    }else if (i == 5){
      calendarHtml += '<td style = "color: blue;">' + weeks[i] + '</td>'
    }else{
      calendarHtml += '<td>' + weeks[i] + '</td>'
    }
  }
  calendarHtml += '</tr>'
  for (let w = 0; w < 6; w++) {
    calendarHtml += '<tr class="">'
    for (let d = 0; d < 7; d++) {
      if (w == 0 && d < startDay) {
        // 1行目で1日の曜日の前
        let num = lastMonthendDayCount - startDay + d + 1
        let unixTime = new Date(year, month-1, num).getTime()/1000
        calendarHtml += '<td class="text-gray-300" id="' + unixTime + '">' + num
        calendarHtml += '<div style="height:100px;"></div>'
        calendarHtml += '</td>'
      } else if (dayCount > endDayCount) {
        // 末尾の日数を超えた
        let num = dayCount - endDayCount
        let unixTime = new Date(year, month-1, num).getTime()/1000
        calendarHtml += '<td class="text-gray-300" id="' + unixTime + '">' + num 
        calendarHtml += '<div style="height:100px; width: 130px;"></div>'
        calendarHtml += '</td>'
        dayCount++
      } else {
        let unixTime = new Date(year, month-1, dayCount).getTime()/1000
        if (dayCount == tDate && month == tMonth && year == tYear) {
          let reservesHTML = ''
          let reserve_key = Object.keys(events).filter(unixKey => unixKey == unixTime);
          if (reserve_key == unixTime) {
            let reserves = events[reserve_key[0]];          
            reserves.forEach(reserve => {            
              let time = reserve.time;
              let id = reserve.id;
              let color = reserve.color;          
              let formattedTime = time.replace(":00", "");
              let editUrlTemplate = "{{ route('reserveCreate.edit', ['id' => ':id']) }}";
              let editUrl = editUrlTemplate.replace(':id', id); // IDをURLに埋め込む
              
              reservesHTML += '<a href="' + editUrl + '" class="bg-'+ color +'-300 hover:bg-'+ color +'-500 rounded-full block mb-1 text-center">';
              reservesHTML += '<small class="p-1 text-xs">' + formattedTime + '</small>';
              reservesHTML += '<small class="p-1 course-name-size">' + reserve.course_name + '</small>';
              reservesHTML += '</a>';
            });
          }
          calendarHtml += '<td class = "border" id="' + unixTime + '"><span class="font-bold underline decoration-double decoration-red-600">' + dayCount + '</span>';
          calendarHtml += '<div class="event-container">' + reservesHTML+ '</div>';
          calendarHtml += '</td>';
          dayCount++;
        } else {
          let reservesHTML = ''
          let reserve_key = Object.keys(events).filter(unixKey => unixKey == unixTime);
          if (reserve_key == unixTime) {
            let reserves = events[reserve_key[0]];
            reserves.forEach(reserve => {
              let time = reserve.time;
              let id = reserve.id;
              let color = reserve.color;
              let formattedTime = time.replace(":00", "");
              let editUrlTemplate = "{{ route('reserveCreate.edit', ['id' => ':id']) }}";
              let editUrl = editUrlTemplate.replace(':id', id); // IDをURLに埋め込む

              reservesHTML += '<a href="' + editUrl + '" class="bg-'+ color +'-300 hover:bg-'+ color +'-500 rounded-full block mb-1 text-center">';             
              reservesHTML += '<small class="p-1 text-xs">' + formattedTime + '</small>';
              reservesHTML += '<small class="p-1 course-name-size">' + reserve.course_name + '</small>';
              reservesHTML += '</a>';
            });
          }
          calendarHtml += '<td class = "border" id="' + unixTime + '">' + dayCount;
          calendarHtml += '<div class="event-container">' + reservesHTML + '</div>';
          calendarHtml += '</td>';
          dayCount++;
        } 
      
      }
    }
    calendarHtml += '</tr>'
  }
  calendarHtml += '</table>'
  // ここでreturnが必要なのは、innerHTMLを使用していないから！returnがないと戻り値を渡せず、showCalendarで定義した
  // const calendarHtml = createCalendar(year, month)が使えず、カレンダーが表示されない。
  return calendarHtml
}
  
function moveCalendar(e) {
  document.querySelector('#calendar').innerHTML = ''
  if (e.target.id === 'prev') {
    month--
    
    if (month < 1) {
      year--
      month = 12
    }
  }
  if (e.target.id === 'next') {
    month++
    if (month > 12) {
      year++
      month = 1
    }

  }
  showCalendar(year, month, events)
}

document.querySelector('#prev').addEventListener('click', moveCalendar)
document.querySelector('#next').addEventListener('click', moveCalendar)
showCalendar(year, month, events)
</script>

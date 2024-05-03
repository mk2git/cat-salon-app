<x-app-layout>
  <div class="container mt-8 mx-auto">
    @if (session('message'))
      <x-alert-message :message="session('message')" />
    @endif

    @if ($errors->any())
           <x-error-message />
    @endif
    <div class="grid gap-6 grid-cols-2">
      <div>
          <p class="text-lg text-center">予約可能日の追加</p>
          <form action="{{route('reserveCreate.store')}}" method="post" class="block w-80 mx-auto mt-3">
            @csrf
            <label class="block mx-auto mb-3">
              <span class="block text-sm font-medium text-slate-700">日付</span>
              <input type="date" name="date" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
                focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
                disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
                invalid:border-pink-500 invalid:text-pink-600
                focus:invalid:border-pink-500 focus:invalid:ring-pink-500
              "/>
            </label>
            <label class="block mx-auto mb-3">
              <span class="block text-sm font-medium text-slate-700">時間</span>
              <input type="time" name="time" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
                focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
                disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
                invalid:border-pink-500 invalid:text-pink-600
                focus:invalid:border-pink-500 focus:invalid:ring-pink-500
              "/>
            </label>
            <label class="block mx-auto mb-6">
              <span class="block text-sm font-medium text-slate-700">コース選択</span>
              <select name="course_id" id="" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
              invalid:border-pink-500 invalid:text-pink-600
              focus:invalid:border-pink-500 focus:invalid:ring-pink-500">
                <option value="" disabled selected>コースを選択してください</option>
                @foreach ($courses as $course)
                  <option value="{{$course->id}}">{{$course->course_name}}</option>
                @endforeach
              </select>
            </label>
            <button type="submit" class="py-2 px-5 bg-orange-500 text-white font-semibold rounded-full shadow-md hover:bg-orange-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto">追加</button>
          </form>
      </div>
      <div>
        {{-- <div id='calendar' data-events='@json($events)'></div> --}}
        <div class="d-flex justify-content-between">
          <button id="prev" type="button" class="btn btn-primary">前の月</button>
          <button id="next" type="button" class="btn btn-primary">次の月</button>
        </div>
        <hr>
        <div id="calendar"></div>
        <script>
          // 関数外での変数定義はグローバル変数という。ここで定義されたものは関数で引数として()内に書かなくても使える
          // 例：　function showCalendar()のyearとmonthを引数として書かなくてもJavaScriptでは問題はない
        const weeks = ['月', '火', '水', '木', '金', '土', '日']
        const date = new Date()
        let year = date.getFullYear()
        let month = date.getMonth() + 1
        // config内に各種設定値を書くと便利
        const config = {
          // マジックナンバー
          // キー:値
          show: 2,
          // 1年分のカレンダーを表示するためのもの。下記のfunction内でmaxYearSpanを利用したコード書く必要あり
          maxYearSpan: 1,
        }
        // 関数内での定義はローカル変数であるため、他の関数内で同じ名前で変数や定数の定義をしても別物として認識される
        function showCalendar(year, month) {
          for ( i = 0; i < config.show; i++) {
            // createCalendarでinnerHTMLを使用しないのはカレンダーを表示する数を調整するのに便利だから
            const calendarHtml = createCalendar(year, month)
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
        function createCalendar(year, month) {
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
          
          calendarHtml += '<h1><small>' + year  + '</small>/' + month + '</h1>'
          calendarHtml += '<table class="table">'
          
          // 曜日の行を作成
          calendarHtml += '<tr>'
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
            calendarHtml += '<tr>'
            for (let d = 0; d < 7; d++) {
              if (w == 0 && d < startDay) {
                // 1行目で1日の曜日の前
                let num = lastMonthendDayCount - startDay + d + 1
                // console.log(num);
                calendarHtml += '<td class="disabled">' + num + '</td>'
              } else if (dayCount > endDayCount) {
                // 末尾の日数を超えた
                let num = dayCount - endDayCount
                // console.log(num);
                calendarHtml += '<td class="disabled">' + num + '</td>'
                dayCount++
              } else {
                if (dayCount == tDate && month == tMonth && year ==tYear){
                  calendarHtml += '<td style = "font-weight: bold; color: green;">' + dayCount + '</td>'
                  dayCount++         
                }else{
                  calendarHtml += '<td>' + dayCount + '</td>'
                  dayCount++
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
          showCalendar(year, month)
        }
        document.querySelector('#prev').addEventListener('click', moveCalendar)
        document.querySelector('#next').addEventListener('click', moveCalendar)
        showCalendar(year, month)
        </script>
      </div>
    </div>
   
  </div>
</x-app-layout>
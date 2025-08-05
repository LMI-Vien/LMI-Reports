    function getCalendarWeeks(year) {
        const weeks = [];
        let date = new Date(year, 0, 4); // Jan 4 is always in the first ISO week
        const day = date.getDay();
        const diff = (day === 0 ? -6 : 1 - day); // move to Monday
        date.setDate(date.getDate() + diff);

        let weekNumber = 1;

        while (date.getFullYear() <= year || (date.getFullYear() === year + 1 && weekNumber < 54)) {
            const weekStart = new Date(date);
            const weekEnd = new Date(date);
            weekEnd.setDate(weekEnd.getDate() + 6);

            if (weekStart.getFullYear() > year && weekEnd.getFullYear() > year) break;

            weeks.push({
                id: weekNumber,
                display: `Week ${weekNumber} (${weekStart.toISOString().slice(0, 10)} - ${weekEnd.toISOString().slice(0, 10)})`,
                week: weekNumber++,
                start: weekStart.toISOString().slice(0, 10),
                end: weekEnd.toISOString().slice(0, 10),
            });

            date.setDate(date.getDate() + 7); // move to next Monday
        }

        return weeks;
    }

    function getCurrentWeek(year = new Date().getFullYear()) {
        const weeks = getCalendarWeeks(year);
        const today = new Date().toISOString().slice(0, 10);

        for (const week of weeks) {
            if (today >= week.start && today <= week.end) {
                return week;
            }
        }

        return null;
    }

    function formatNumberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function formatTwoDecimals(data) {
        if(data == "N/A"){
            return data;
        }
        return data ? Number(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
    }


    function formatNoDecimals(data) {
        if(data == "N/A"){
            return data;
        }
        return data ? Number(data).toLocaleString('en-US', { maximumFractionDigits: 0 }) : '0';
    }

    function formatFourDecimals(data) {
        if(data == "N/A"){
            return data;
        }
        return data ? Number(data).toLocaleString('en-US', { minimumFractionDigits: 4, maximumFractionDigits: 4 }) : '0.0000';
    }

    function formatDateToMMDDYYYY(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        if (isNaN(date)) return '';
        const month = ('0' + (date.getMonth() + 1)).slice(-2);
        const day = ('0' + date.getDate()).slice(-2);
        const year = date.getFullYear();
        return `${month}/${day}/${year}`;
    }

    function formattedDate(data) {
        if (!data) return ''; 

        let date = new Date(data);
        let options = { month: 'short', day: '2-digit', year: 'numeric' };
        return date.toLocaleDateString('en-US', options).replace(',', '');
    }

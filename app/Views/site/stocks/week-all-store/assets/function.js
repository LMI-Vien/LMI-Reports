function updateWeeks(id) {
    let selectedYear = $('#year option:selected').text()
    populateDropdown(id, getCalendarWeeks(selectedYear), 'display', 'id');
}

const getCalendarWeeks = (year) => {
    const weeks = [];
    const startDate = new Date(year, 0, 1); // Jan 1
    const day = startDate.getDay(); // day of the week (0 = Sunday)
    
    const firstMonday = new Date(startDate);
    if (day !== 1) {
        const offset = (day === 0 ? 1 : (9 - day)); 
        firstMonday.setDate(startDate.getDate() + offset);
    }
    
    let currentDate = new Date(firstMonday);
    let weekNumber = 1;
    
    while (currentDate.getFullYear() <= year) {
        const weekStart = new Date(currentDate);
        const weekEnd = new Date(currentDate);
        weekEnd.setDate(weekEnd.getDate() + 6);
    
        if (weekStart.getFullYear() > year) break;
        
        weeks.push({
            id: weekNumber,
            display: `Week ${weekNumber} (${weekStart.toISOString().slice(0, 10)} - ${weekEnd.toISOString().slice(0, 10)})`,
            week: weekNumber++,
            start: weekStart.toISOString().slice(0, 10),
            end: weekEnd.toISOString().slice(0, 10),
        });
        
        currentDate.setDate(currentDate.getDate() + 7);
    }
    
    return weeks;
}

const populateDropdown = (selected_class, result, textKey = 'name', valueKey = 'id') => {
    let html = '<option id="default_val" value=" ">Select</option>';
    
    if (result && result.length > 0) {
        result.forEach((item) => {
            html += `<option value="${item[valueKey]}">${item[textKey]}</option>`;
        });
    }
    
    $('#' + selected_class).html(html);
};
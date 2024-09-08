<div class="date-range-picker-component">
    <div class="form-group">
        <label class="form-label">{{$label}}</label>
        <div class="input-group custom-datepicker" data-range="init">
            <input placeholder="dd/mm/yyyy" data-format="dd/mm/yyyy" type="text" class="form-control" name="start_date" id="component_start_date" value="{{ $startDate }}">
            <span class="input-group-text">to</span>
            <input placeholder="dd/mm/yyyy" data-format="dd/mm/yyyy" type="text" class="form-control" name="end_date" id="component_end_date" value="{{ $endDate }}">
            <span class="input-group-text" id="how-many-month-days">0 day</span>
        </div>

        <div class="mt-3">
            <label class="form-label">Duration</label>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-light btn-sm" id="component_three_year_btn" disabled>3 Years</button>
                <button type="button" class="btn btn-light btn-sm" id="component_two_year_btn" disabled>2 Years</button>
                <button type="button" class="btn btn-light btn-sm" id="component_one_year_btn" disabled>1 Year</button>
                <button type="button" class="btn btn-light btn-sm" id="component_six_months_btn" disabled>6 Months</button>
                <button type="button" class="btn btn-light btn-sm" id="component_three_months_btn" disabled>3 Months</button>
            </div>
        </div>
    </div>
</div>

@push('js-stack')
    <script src="/js/day.js"></script>
    <script src="/js/dayjs-customParse.js"></script>
    <script>
        dayjs.extend(dayjs_plugin_customParseFormat);
        class DateRangePickerComponent {
            constructor(container) {
                this.container = container;
                this.startDateInput = container.querySelector('#component_start_date');
                this.endDateInput = container.querySelector('#component_end_date');
                this.threeYearBtn = container.querySelector('#component_three_year_btn');
                this.twoYearBtn = container.querySelector('#component_two_year_btn');
                this.oneYearBtn = container.querySelector('#component_one_year_btn');
                this.sixMonthsBtn = container.querySelector('#component_six_months_btn');
                this.threeMonthsBtn = container.querySelector('#component_three_months_btn');
                this.daysDisplay = container.querySelector('#how-many-month-days');

                this.initDatePicker();
                this.bindEvents();
            }

            initDatePicker() {
                // Initialize the DateRangePicker
                const dpElement = this.container.querySelector('.custom-datepicker');
                new DateRangePicker(dpElement, {
                    autohide: true,
                    buttonClass: 'btn btn-md',
                    orientation: 'bottom',
                    todayButton: false,
                    format: 'dd/mm/yyyy',
                });
            }

            bindEvents() {
                // Enable the buttons when a start date is selected
                this.startDateInput.addEventListener('changeDate', () => {
                    if (this.startDateInput.value) {
                        this.threeYearBtn.disabled = false;
                        this.twoYearBtn.disabled = false;
                        this.oneYearBtn.disabled = false;
                        this.sixMonthsBtn.disabled = false;
                        this.threeMonthsBtn.disabled = false;
                        this.updateDayDifference(); // Trigger calculation when start date is set
                    }
                });

                // Trigger day calculation when the end date changes
                this.endDateInput.addEventListener('changeDate', () => {
                    this.updateDayDifference();
                });

                this.threeMonthsBtn.addEventListener('click', () => {
                    this.setDateBasedOnOffset(3, 'month');
                    this.updateDayDifference();
                });

                // Add 2 years from the selected start date
                this.twoYearBtn.addEventListener('click', () => {
                    this.setDateBasedOnOffset(2, 'year');
                    this.updateDayDifference();
                });

                // Add 1 year from the selected start date
                this.oneYearBtn.addEventListener('click', () => {
                    this.setDateBasedOnOffset(1, 'year');
                    this.updateDayDifference();
                });

                // Add 6 months from the selected start date
                this.sixMonthsBtn.addEventListener('click', () => {
                    this.setDateBasedOnOffset(6, 'month');
                    this.updateDayDifference();
                });

                // Add 3 years from the selected start date
                this.threeYearBtn.addEventListener('click', () => {
                    this.setDateBasedOnOffset(3, 'year');
                    this.updateDayDifference();
                });
            }

            // Helper function to format the date as dd/mm/yyyy
            formatDate(date) {
                const day = ("0" + date.getDate()).slice(-2);
                const month = ("0" + (date.getMonth() + 1)).slice(-2);
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }

            // Helper function to set the end date based on the offset
            setDateBasedOnOffset(offset, type) {
                const startDate = new Date(this.startDateInput.value.split('/').reverse().join('-'));
                const updatedDate = new Date(startDate);

                if (type === 'year') {
                    updatedDate.setFullYear(startDate.getFullYear() + offset);
                } else if (type === 'month') {
                    updatedDate.setMonth(startDate.getMonth() + offset);
                }

                this.endDateInput.value = this.formatDate(updatedDate);
            }

            // Calculate the number of days between start and end date
            updateDayDifference() {
                if (this.startDateInput.value && this.endDateInput.value) {
                    // const startDate = new Date(this.startDateInput.value.split('/').reverse().join('-'));
                    // const endDate = new Date(this.endDateInput.value.split('/').reverse().join('-'));
                    const startDate = dayjs(this.startDateInput.value, 'DD/MM/YYYY');
                    const endDate = dayjs(this.endDateInput.value, 'DD/MM/YYYY');

                    const timeDiff = endDate - startDate;
                    const dayDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)); // Convert from milliseconds to days

                    // from day count year first, then get month, and then remaining days
                    const years = endDate.diff(startDate, 'year');
                    const months = endDate.diff(startDate, 'month') - years * 12;
                    const days = endDate.diff(startDate.add(years, 'year').add(months, 'month'), 'day');

                    let displayText = '';
                    if (years > 0) {
                        displayText += `${years} year${years > 1 ? 's' : ''} `;
                    }
                    if (months > 0) {
                        displayText += `${months} month${months > 1 ? 's' : ''} `;
                    }
                    if (days > 0) {
                        displayText += `${days} day${days > 1 ? 's' : ''}`;
                    }

                    // if only years or months remove the comma
                    if (days == 0 || (months == 0 && days == 0)) {
                        displayText = displayText.trim().replace(',', '');
                    }

                    this.daysDisplay.textContent = displayText;
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const dateRangePickerElement = document.querySelector('.date-range-picker-component');
            new DateRangePickerComponent(dateRangePickerElement);

            // trigger change function
            const event = new Event('changeDate');
            dateRangePickerElement.querySelector('#component_start_date').dispatchEvent(event);
        });
    </script>
@endpush

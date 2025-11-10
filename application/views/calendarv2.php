<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Calendar</title>

    <!-- ✅ Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />

    <style>
        body {
            background-color: #f8f9fa;
        }

        #calendar {
            max-width: 900px;
            margin: 60px auto;
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .datepicker-inline {
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="text-center mt-4">📅 My Personal Calendar</h2>
        <div id="calendar"></div>
    </div>

    <!-- ✅ Bootstrap Modal for Adding Event -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Update Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm" method="POST" action="<?= site_url('calendar/save_event') ?>">
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Event Title</label>
                            <input type="text" class="form-control" id="eventTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventStatus" class="form-label">Event Status</label>
                            <select id="eventStatus" name="status" class="form-select">
                                <option value="private" selected>Private</option>
                                <option value="public">Public</option>
                            </select>
                        </div>
                        <input type="hidden" id="start" name="start">
                        <input type="hidden" id="end" name="end">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveEventBtn">Save Event</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Axios, Bootstrap JS, FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
                events: '<?= site_url("calendar/fetch_events") ?>',

                select: function(info) {
                    // Open the modal when a date range is selected
                    var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                    modal.show();

                    // Set the title field for the event
                    document.getElementById('eventTitle').value = '';

                    // Set the start and end date values in hidden fields
                    document.getElementById('start').value = info.startStr;
                    document.getElementById('end').value = info.endStr;

                    // Save event button logic (submit the form)
                    document.getElementById('saveEventBtn').onclick = function() {
                        document.getElementById('eventForm').submit(); // Submit the form normally
                    };
                },

                eventClick: function(info) {
                    // Open the modal when an event is clicked and pre-populate fields
                    var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                    modal.show();

                    // Populate the title and status fields from the event clicked
                    document.getElementById('eventTitle').value = info.event.title;
                    document.getElementById('eventStatus').value = info.event.extendedProps.status || 'private';

                    // Set the start and end date values in hidden fields
                    document.getElementById('start').value = info.event.start.toISOString();
                    document.getElementById('end').value = info.event.end ? info.event.end.toISOString() : null;

                    // Save event button logic (submit the form)
                    document.getElementById('saveEventBtn').onclick = function() {
                        document.getElementById('eventForm').submit(); // Submit the form normally
                    };
                },

                eventDrop: function(info) {
                    // Open the modal on event drop and pre-populate fields
                    var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                    modal.show();

                    // Populate the title and status fields from the dragged event
                    document.getElementById('eventTitle').value = info.event.title;
                    document.getElementById('eventStatus').value = info.event.extendedProps.status || 'private';

                    // Set the start and end date values in hidden fields
                    document.getElementById('start').value = info.event.start.toISOString();
                    document.getElementById('end').value = info.event.end ? info.event.end.toISOString() : null;

                    // Save event button logic (submit the form)
                    document.getElementById('saveEventBtn').onclick = function() {
                        document.getElementById('eventForm').submit(); // Submit the form normally
                    };
                }
            });

            calendar.render();

            // Reset form when modal is hidden
            $('#eventModal').on('hidden.bs.modal', function() {
                resetForm();
            });

            // Function to reset the form fields
            function resetForm() {
                document.getElementById('eventForm').reset();
            }
        });
    </script>
</body>

</html>
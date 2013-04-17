AfterEvent.info Event Management System.
This Current Branch deals with the BlackBerry Alisha Keys Tour directly.

CHANGE LOG:

2013-02-23 20:00 PST -------
* Added guest checkin scripts for BlackBerry app.
* Fixed Styling on sidebar
* Removed phpmailer class
* Created guestManager class
* Started CSV upload feature of guests
* Ticketing and Staffing Page and action script changes to deal with error reporting to the end user

2013-02-22 17:45 PST -------
* Added guestGroups
* Added /registration/
* Registration requires a valid `invite` code (`regID` in `guests` Table)
* Added `regID` (Unique VARCHAR(255)) to `guests` Table
* Added Messaging Class for Emails
* Intigrated Mandrill Support
* Added BlackBerry Branded Styling

2013-02-21 12:17 PST -------
* Added `appID` (Unique VARCHAR(255)) to `events` Table
    * This is used as a unique idendifier for the BlackBerry App to correctly select the event without it being an incrimental intval
* Removed `tickets` FROM `guests`
* Added `ticketTypeID` (INT(11)) to `guests`
    * A guest has 1 and only 1 ticket, no more arrays of tickets for guests.
* Created sample data for `guests`
    * Added 28 rows for `eventID` 1 for testing.
* Updated .gitignore to also include js/afterevent.js
    * The top line needs to be changed to match localhost structure.
* New Action Script: AddSampleData.php
    * Was used to add the 28 sample data rows into `guests`
* New Action script: app-login.php
    * This is used by the BlackBerry App to check cridentials and returns a guest list if a valid appID is provided.
* Updated pre-processing/event/guests.php
    * Removed the SQL query to get the guest list.  We are using ajax calls via dataTables.js so this query is no longer used.
* Updated actions/dataTables_ajax.php
    * Updated the query and results to match the new structure for `guests` table.
	
2013-02-20 14:43 PST -------
* Innitial Setup of Application and Github Installation.
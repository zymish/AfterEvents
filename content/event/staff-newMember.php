<?php require_once('event-nav.php'); ?>
<div class='row-fluid'>
	<div class='span12 widget-box'>
		<form accept-charset="UTF-8" action='<?= SITE_ROOT . "event.staff/".$projectID."/".$eventID ?>' method="post" class="form-horizontal">
			<input type="hidden" name="action" value='newStaff'>
			<input type="hidden" name="userID">
			<input type="hidden" name="groupID" value='<?=$groupID?>'>
			<input type="hidden" name="eventID" value='<?=$eventID?>'>
			<input type='hidden' name='invitedBy' value='<?=getCurrentUserID()?>'>
			<div class="widget-title">
				<h5>New <span class="groupName"><?=$group['title']?></span> Staff Member</h5>
			</div>
			<div class="widget-content">
			<h5>BA Contact Info:</h5>
            
            <div class="control-group">
                <label class="control-label">Name:</label>
                <div class="controls">
                	<input type="text" placeholder="First Name" name="firstName">
                    <input type="text" placeholder="Last Name" name="lastName">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Email:</label>
                <div class="controls">
                    <input type="text" placeholder="Email" name="email">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Mobile:</label>
                <div class="controls">
                	<input type="text" placeholder="Mobile" name="mobile">
                </div>
            </div>
			<div class='control-group'>
				<label class='control-label'>Gender:</label>
				<div class='controls'>
					<select name='gender' class="input-medium">
						<option value='null'>Unknown</option>
						<option value='male'>Male</option>
						<option value='female'>Female</option>
					</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Dress Size:</label>
				<div class='controls'>
					<input type='text' placeholder='Dress Size' name='dressSize'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Shirt Size:</label>
				<div class='controls'>
					<input type='text' placeholder='Shirt Size' name='shirtSize'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Pants Size:</label>
				<div class='controls'>
					<input type='text' placeholder='Pants Size' name='pantsSize'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Shoe Size:</label>
				<div class='controls'>
					<input type='text' placeholder='Shoe Size' name='shoeSize'>
				</div>
			</div>
			<h5>Emergency Contact:</h5>
			<div class='control-group'>
				<label class='control-label'>Name:</label>
				<div class='controls'>
					<input type='text' placeholder='Name' name='emergencyName'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Phone:</label>
				<div class='controls'>
					<input type='text' placeholder='Phone' name='emergencyPhone'>
				</div>
			</div>
			<h5>BA Event Info:</h5>
			<div class='control-group'>
				<label class='control-label'>Time In:</label>
				<div class='controls'>
					<input type='text' placeholder='Time In' name='timeIn'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Time Out:</label>
				<div class='controls'>
					<input type='text' placeholder='Time Out' name='timeOut'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Paperwork Signed:</label>
				<div class='controls'>
					<input type='checkbox' name='paperwork'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>On-Site Training:</label>
				<div class='controls'>
					<input type='text' placeholder='On-Site Training' name='onSiteTraining'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Device Issued:</label>
				<div class='controls'>
					<input type='text' placeholder='Device Issued' name='deviceIssued'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Uniform Issued:</label>
				<div class='controls'>
					<input type='text' placeholder='Uniform Issued' name='uniformIssued'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Uniform Returned:</label>
				<div class='controls'>
					<input type='text' placeholder='Uniform Returned' name='uniformReturned'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>No. of Staff:</label>
				<div class='controls'>
					<input type='text' placeholder='No. of Staff' name='staffNo'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Manager on Duty:</label>
				<div class='controls'>
					<input type='text' placeholder='Manager on Duty' name='onDutyMan'>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save Staff</button>
			</div>
		</form>
	</div>
</div>
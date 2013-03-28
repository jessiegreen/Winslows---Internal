var Company_Contact_Log_Contact_Edit = function (){
    
}

Company_Contact_Log_Contact_Edit.prototype.FormAddPerson = function(person_id, person_name)
{
    ele			    = $( "#company_contact_log_contact-people" );
    current_val		    = jQuery.parseJSON(ele.val());
    current_val[person_id]  = person_name;
    
    ele.val(JSON.stringify(current_val));
}
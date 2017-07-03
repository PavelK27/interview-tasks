/*
 * Address Book JavaScript
 */

(function(window){
	'use strict';

	/**
	 * Creates a single contact object.
	 *
	 * @param {string} first_name - contact first name
	 * @param {string} last_name - contact last name
	 * @param {string} email - contact email address
	 * @param {string} phone - contact mobile number
	*/
	function Contact( first_name, last_name, email, phone ) {
		this.first_name = first_name;
		this.last_name = last_name;
		this.email = email;
		this.phone = phone;
	}

	// Declare Contacts object.
	var contacts = new Object();
	contacts.list = [];

	/**
	* Adds a new contact to storage and renders it in the view.
	*
	* @param {string} first_name - contact first name
	* @param {string} last_name - contact last name
	* @param {string} email - contact email address
	* @param {string} phone - contact mobile number
	*/
	contacts.add = function( first_name, last_name, email, phone ) {
		// Add a new Contact instance.
		var new_contact = new Contact( first_name, last_name, email, phone );

		// Update the dom.
		contacts.renderNewContact( new_contact );

		// Update contacts list array.
		contacts.list.push( new_contact );
	};

	/**
	* Renders new contact into the template.
	*
	* @param {object} data - the array of contact data to be rendered
	*/
	contacts.renderNewContact = function( data ) {
		// Create a <option> node.
		var node = document.createElement( 'option' );

		// Create a text node.
		var textnode = document.createTextNode( data.first_name + ' ' + data.last_name + ', ' + data.phone + ', ' + data.email );

		// Append the text to <option>
		node.appendChild( textnode );

		// Append option to select box.
		document.getElementById( 'contacts-list' ).appendChild( node );

		// Remove "No contacts" option.
		var no_contacts = document.getElementById( 'no-contacts' );

		if ( typeof( no_contacts ) != 'undefined' && no_contacts != null ) {
			document.getElementById( 'contacts-list' ).removeChild(no_contacts)
		}

		// Empty input fields.
		var inputs = document.getElementsByTagName( 'input' );
		for ( var i=0; i < inputs.length; i++ ) {
			inputs[i].value = "";
		}

	}

	/**
	* Validate form - check if all inputs are filled.
	*/
	contacts.validateForm = function() {
		var form = document.getElementById( 'main-form' ), inputs = form.getElementsByTagName( 'input' ), input = null, flag = true;

		// Loop through all inputs.
		for ( var i = 0, len = inputs.length; i < len; i++ ) {
			input = inputs[i];

			// If input is empty, focus on it and display an alert.
			if ( ! input.value ) {
				flag = false;
				input.focus();
				alert( 'Please fill in all the required fields.' );
				break;
			}
		}
		return (flag);
	}

	/**
	* Bind events for contact list.
	*/
	contacts.bindEvents = function() {
		// Store the add contact button for later use.
		var add_btn = document.getElementById( 'add-button' );

		// Add a click event to handle the form submit.
		add_btn.addEventListener( 'click', function(e) {
			e.preventDefault();

			// Validate form.
			var is_valid = contacts.validateForm();
			if ( ! is_valid ) {
				return false;
			}

			// Define variables using the form data.
			var contact_data = {
				first_name: this.form.first_name.value,
				last_name: this.form.last_name.value,
				email: this.form.email.value,
				phone: this.form.phone.value
			}

			var new_contact = contacts.add( contact_data.first_name, contact_data.last_name, contact_data.email, contact_data.phone );
		});

	}

contacts.bindEvents();

}(window));

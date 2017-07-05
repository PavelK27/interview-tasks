/*
 * Address Book JavaScript
 */

(function(window){
	'use strict';

		// Declare Contacts object.
		var contacts = {
			list: [],
			prev_id: 0
		};

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
		this.id = contacts.prev_id + 1;
		contacts.prev_id = this.id;
	}

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

		// Add contact id to option.
		node.setAttribute( 'id', data.id );

		// Add contact name attr to option.
		node.setAttribute( 'data-name', data.first_name );

		// Add contact last name attr to option.
		node.setAttribute( 'data-last-name', data.last_name );

		// Add contact phone attr to option.
		node.setAttribute( 'data-phone', data.phone );

		// Add contact email attr to option.
		node.setAttribute( 'data-email', data.email );

		// Create a text node.
		var textnode = document.createTextNode( data.first_name + ' ' + data.last_name + ', ' + data.phone + ', ' + data.email );

		// Append the text to <option>
		node.appendChild( textnode );

		// Append option to select box.
		document.getElementById( 'contacts-list' ).appendChild( node );

		// Remove "No contacts" option.
		var no_contacts = document.getElementById( 'no-contacts' );

		if ( typeof( no_contacts ) != 'undefined' && no_contacts != null ) {
			document.getElementById( 'contacts-list' ).removeChild( no_contacts );
		}

		// Empty input fields.
		var inputs = document.getElementsByTagName( 'input' );
		for ( var i=0; i < inputs.length; i++ ) {
			inputs[i].value = "";
		}

	};

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
	};

	/**
	* Removes contact from contacts list and contacts object.
	*
	* @param {array} remove_contacts - the array of contact ids to be removed.
	*/
	contacts.remove = function( remove_contacts ) {
		var all_contacts = contacts.list;
		var new_contacts = new Array();
		var selectbox = document.getElementById( 'contacts-list' );

		// Loop through all contacts.
		for ( var i = 0; i < all_contacts.length; i++ ) {
			// If any of them matches from remove_contacts array, delete it.
			if ( remove_contacts.indexOf( all_contacts[i].id ) === -1 ) {
					new_contacts.push( all_contacts[i] );
			}
		}

		// Update selectbox options.
		var options = selectbox.options;
		var k = options.length;

		// Loop through all select options and remove the ones were selected.
		while ( k-- ) {
			var current = options[k];
			if ( current.selected ) {
				selectbox.remove( k );
			}
		}

		// Update contacts list object.
		contacts.list = new_contacts;
	};

	/**
	* Sorts contacts by attribute.
	*
	* @param {string} attr - Attribute name which will be used for sorting.
	*/
	contacts.sort = function( attr ) {

		var contacts_select = document.getElementById( 'contacts-list' );
		var new_options = new Array();
		
		// Loop through old options and add them to new options array.
		for ( var i = 0; i < contacts_select.options.length; i++ ) {

			// Each option key will be an array.
			new_options[i] = new Array();

			// The first key of this array is used for sorting, so we need to populate it with attr value.
			new_options[i][0] = contacts_select.options[i].getAttribute(attr);

			// We also need to keep item's attributes.
			new_options[i]['text'] = contacts_select.options[i].text;
			new_options[i]['id'] = contacts_select.options[i].getAttribute( 'id' );
			new_options[i]['name'] = contacts_select.options[i].getAttribute( 'data-name' );
			new_options[i]['last_name'] = contacts_select.options[i].getAttribute( 'data-last-name' );
			new_options[i]['phone'] = contacts_select.options[i].getAttribute( 'data-phone' );
			new_options[i]['email'] = contacts_select.options[i].getAttribute( 'data-email' );
		}

		// Sort new options, [0] key will be used for sorting.
		new_options.sort();

		// Empty original selectbox.
		while (contacts_select.options.length > 0) {
			contacts_select.options[0] = null;
		}

		// Populate selectbox with re-arranged options.
		for ( var k = 0; k < new_options.length; k++ ) {
			// Create a new option node with text attribute value.
			var option = new Option( new_options[k]['text'] );

			// Add other attributes we wanted to keep.
			option.setAttribute( 'id', new_options[k]['id'] );
			option.setAttribute( 'data-name', new_options[k]['name'] );
			option.setAttribute( 'data-last-name', new_options[k]['last_name'] );
			option.setAttribute( 'data-phone', new_options[k]['phone'] );
			option.setAttribute( 'data-email', new_options[k]['email'] );

			// Add new option to the selectbox.
			contacts_select.options[k] = option;
		}

		return;
	};

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
		//	var is_valid = contacts.validateForm();
			//if ( ! is_valid ) {
			//	return false;
			//}

			// Define variables using the form data.
			var contact_data = {
				first_name: this.form.first_name.value,
				last_name: this.form.last_name.value,
				email: this.form.email.value,
				phone: this.form.phone.value
			};

			contacts.add( contact_data.first_name, contact_data.last_name, contact_data.email, contact_data.phone );
		});

		// Store the delete contact button for later use.
		var remove_btn = document.getElementById( 'delete-button' );

		// Add a click event for contact removal.
		remove_btn.addEventListener( 'click', function(e) {
			e.preventDefault();

			var select_box = this.form.contacts_list;
			var select_value = [];

			// Loop through all options and get the selected ones.
			for ( var i = 0; i < select_box.selectedOptions.length; i++ ) {
				select_value.push( parseInt( select_box.selectedOptions[i].id ) );
			}

			if ( select_value ) {
				contacts.remove( select_value );
			}
		});

		// Store the select dropdown for later use.
		var select_box = document.getElementById( 'sort' );

		// Add a click event to handle the form submit.
		select_box.addEventListener( 'change', function(e) {
			contacts.sort( this.value );
		});

	};

contacts.bindEvents();

}(window));

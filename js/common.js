var arrItemsKid = new Map();
var arrErrorMessages = new Map();  
var reCaptchaSelected = false;


/**
 * ReCaptcha selected by User
 */
function selectReCaptcha()
{
    reCaptchaSelected = true;
}


/**
 * Resize reCAPTCHA to fit width of container
**/
function resizeReCaptcha() 
{      
    var width = $( ".g-recaptcha" ).parent().width();
  
  if (width < 302) {
      var scale = width / 302;
  } else {
      var scale = 1;
  }
  
  $( ".g-recaptcha" ).css("transform", "scale(" + scale + ")");
  $( ".g-recaptcha" ).css("-webkit-transform", "scale(" + scale + ")");
  $( ".g-recaptcha" ).css("transform-origin", "0 0");
  $( ".g-recaptcha" ).css("-webkit-transform-origin", "0 0");
}


/**
 * Checking fields of forms.
 * @param formId - id of submitted form.
 * @returns Result of validation. true - valid, false - not valid.
 */
function validateForm(formId)
{
    var form = document.getElementById(formId);
    
    var errorDivs = form.getElementsByClassName("form__error");
    removeListElements(errorDivs);
        
    var fieldsValid = validateFormInputs(form);
    var reCaptchaValid = validateFormReCaptcha();
    var radioSelected = validateRadioButtons(form);
    
    return fieldsValid && reCaptchaValid && radioSelected;
}


/**
  * Checking input fields of submitted form (without button element)
  * @param form - submitted form element.
  * @returns Result of validation. true - valid, false - not valid.
 **/
function validateFormInputs(form)
{
    var valid = true;
    var formElements = form.elements;
    
    for(var i=0; i<formElements.length; i++)
    {
        var element = formElements.item(i);
        element.value = element.value.trim();
        
        if(element.value === "")
        {
            if (element.classList.contains("required"))
            {
                addRedBorderStyle(element);
                addErrorMessage(element, "lg_err_empty_field", "form__error");
                valid = false;
            }
        }
        else
        {
            switch(element.id)
            {
                case "name":
                	if(!isLengthMatch(element.value, 2, 20))
                    {
                        addRedBorderStyle(element);
                        addErrorMessage(element, "lg_err_length_2to20", "form__error");
                        valid = false;
                    }
                	else if(!isOnlyLetters(element.value))
                    {
                        addRedBorderStyle(element);
                        addErrorMessage(element, "lg_err_letters", "form__error");
                        valid = false;
                    }
                    break;
                    
                case "login":
                    if(!isLengthMatch(element.value, 2, 20))
                    {
                        addRedBorderStyle(element);
                        addErrorMessage(element, "lg_err_length_3to20", "form__error");
                        valid = false;
                    }
                    else if(!isOnlyLettersNums(element.value))
                    {
                        addRedBorderStyle(element);
                        addErrorMessage(element, "lg_err_alnum", "form__error");
                        valid = false;
                    }
                    break;
                    
                case "email":
                    if(!isEmailFormat(element.value))
                    {
                        addRedBorderStyle(element);
                        addErrorMessage(element, "lg_err_email", "form__error");
                        valid = false;
                    }
                    break;
                    
                case "password":
                    if(!isLengthMatch(element.value, 8, 20))
                    {
                        addRedBorderStyle(element);
                        addErrorMessage(element, "lg_err_length_8to20", "form__error");
                        valid = false;
                    }
                    break;
                    
                case "confirmPassword":
                    var password = document.getElementById("password").value;
                    var confirmPassword = element.value;
                    if(password !== confirmPassword)
                    {
                        addRedBorderStyle(element);
                        addErrorMessage(element, "lg_err_confirm_password", "form__error");
                        valid = false;
                    }
                    break;
                    
                default:
            }
        }
    }
    return valid;
}


/**
  * Checking reCaptcha of submitted form
  * @returns Result of validation. true - valid, false - not valid.
 **/
function validateFormReCaptcha()
{
    var valid = true; 
    var reCaptcha = document.getElementById("reCaptcha");
    
    if(reCaptcha !== null)
    {
        if(!reCaptchaSelected)
        {
            addErrorMessage(reCaptcha, "lg_err_captcha", "form__error");
            valid = false;
        }
    }
    return valid;
}


/**
 * Checking fields of forms.
 * @param form - submitted form.
 * @returns Result of validation. true - valid, false - not valid.
 */
function validateRadioButtons(form)
{
    var valid = true;
    var formElements = form.elements;
    var radioButtons = new Map();
    
    for (var i=0; i<formElements.length; i++) 
    {
        if (formElements[i].type === "radio") 
        {
            if(radioButtons.has(formElements[i].name))
            {
                radioButtons.get(formElements[i].name).push(formElements[i]);
            }
            else
            {
                radioButtons.set(formElements[i].name, [formElements[i]]);
            }
        }
    }
    
    for (let radioButtonsWithSameName of radioButtons.values())
    {
        var selected = false;
        for (var j=0; j<radioButtonsWithSameName.length; j++)
        {
            selected |= radioButtonsWithSameName[j].checked;
        }
        
        if(!selected)
        {
            addRedBorderStyle(radioButtonsWithSameName[0].parentNode);
            addErrorMessage(radioButtonsWithSameName[0], "lg_err_check_option", "form__error");
            valid = false;
        }
    }
    
    return valid;
}


/**
  * Adding error message to submitted form
  * @param element - element for checking.
  * @param errorName - name of the error found.
 **/
function addErrorMessage(element, errorName, className)
{      
    var divError = document.createElement("div");
    divError.setAttribute("id", "err_"+element.id);
    divError.setAttribute("class", className);
    element.parentNode.appendChild(divError);
    
    try 
    {
        divError.innerText = getErrorMessage(errorName);
    }
    catch(exception)
    {
        divError.innerText = exception;
    }
}


/**
  * Getting text error message from server in the selected language.
  * @param errorName - name of the error.
  * @returns text error message from server in the selected language.
 **/
function getErrorMessage(errorName)
{
    if(arrErrorMessages.has(errorName))
    {
        return arrErrorMessages.get(errorName);
    }
    else
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() 
        {
            if (this.readyState === 4 && this.status !== 200)
            {
                throw JSON.parse(this.responseText).message;
            }
        };
        xhttp.open("GET", "/gaintimeoff/errormessage/get?errorName="+errorName, false);
        xhttp.send();

        var errorObject = JSON.parse(xhttp.responseText);
        arrErrorMessages.set(errorName, errorObject.message);
        return errorObject.message;
    }
}


/**
  * Removing border style.
  * @param element - HTML element.
 **/
function removeBorderStyle(element)
{
    element.style.border = null;
}


/**
 * Adding border style.
 * @param element - HTML element.
**/
function addRedBorderStyle(element)
{
	element.style.border = "1px solid red";
}


/**
 * Redirect function click() to another element
 */
function clickInputFile()
{
    var fileReal = document.getElementById("add-file__real");
    fileReal.click();
}


/**
 * Creating the name of the attached file.
**/
function addFileName()
{
    var fileReal = document.getElementById("add-file__real");
    var fileTxt = document.getElementById("add-file__text");
    var fileTxtValue = document.getElementById("add-file__text").textContent;
    
    if (fileReal.value) 
    {
        fileTxt.innerHTML = fileReal.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
    } 
    else 
    {
        fileTxt.innerHTML = fileTxtValue;
    }
}


/**
 * Deleting the attached file
**/
function clearFile()
{
    var inputFile = document.getElementById("add-file__real");
    var fileTxt = document.getElementById("add-file__text");
    inputFile.value = "";
    fileTxt.innerHTML = "&hellip;";
}


/**
 * Moving class = "active-profile" among kids.
 * @param kidElement - HTML element of selected kid.
**/
function moveActiveProfile(kidElement)
{
    var kids = document.getElementsByClassName("kid");
    for(var i=0; i<kids.length; i++)
    {
        kids[i].classList.remove("active-profile");
    }

    var newActiveProfile = kidElement;
    newActiveProfile.classList.add("active-profile");
    document.getElementById("items").innerHTML = getItemsKid(kidElement.id);
}


/**
 * Removing array with elements.
 * @param elements - array with elements.
**/
function removeListElements(elements)
{
    while (elements.length > 0)
    {
    	elements[0].remove();
    }
}


/**
 * Getting html code of items block from server.
 * @param kidName - name of the kid.
 * @returns  html code of items block from server.
**/
function getItemsKid(kidName)
{
	if(arrItemsKid.has(kidName))
    {
        return arrItemsKid.get(kidName);
    }
	else
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState === 4 && this.status !== 200)
            {
                throw JSON.parse(this.responseText).message;
            }
        };
        xhttp.open("GET", "/gaintimeoff/kidtemplate/items?kidName="+kidName, false);
        xhttp.send();

        arrItemsKid.set(kidName, xhttp.responseText);
        return xhttp.responseText;
    }
}


/**
 * Creating new element into list of subjects/tasks.
 * Before processing value is trimmed
 * @param inputId - id of input element which get name of new subject.
**/
function createNewElement(inputId)
{	
	var errorDivs = document.getElementsByClassName("item__error");
	removeListElements(errorDivs);
	
	var input = document.getElementById(inputId);
	input.value = input.value.trim();
	
	if(checkItemName(input))
	{
		var ul = document.getElementById("itemList");
		var li = document.createElement("li"); 
		li.classList.add("item__new");
		li.appendChild(document.createTextNode(input.value));
		var img = document.createElement("img");
		img.src = "/gaintimeoff/img/delete-16.png";
		img.addEventListener("click", function() {
			deleteElement(this.parentElement);
		});
		li.appendChild(img);
		ul.appendChild(li); 
		input.value = "";
	}
}


/**
 * Checking new Subject name.
 * @param input - input element which get name of new subject.
 * @returns result of checking. true - check was successful, false - check failed.
**/
function checkItemName(input)
{
	var itemNameIsCorrect = true;
	
	var newItems = document.getElementsByClassName("item__new");
	var newItemsArr = Array.from(newItems);
	
	var existingItems = document.getElementsByClassName("item-list__existing");
	var existingItemsArr = Array.from(existingItems);
	
	if(!isLengthMatch(input.value, 2, 20))
	{		
		addRedBorderStyle(input);
		addErrorMessage(input.parentElement, "lg_err_length_2to20", "item__error");
		itemNameIsCorrect = false;
	}
	else if(!isOnlyLettersNums(input.value))
	{
		addRedBorderStyle(input);
		addErrorMessage(input.parentElement, "lg_err_alnum", "item__error");
		itemNameIsCorrect = false;
	}
	else if(checkRepeatedItem(input.value, newItemsArr))
	{		
		addRedBorderStyle(input);
		addErrorMessage(input.parentElement, "lg_err_sub_replay", "item__error");
		itemNameIsCorrect = false;
	}
	else if(!checkUniqueItem(input.value, existingItemsArr))
	{
		addRedBorderStyle(input);
		addErrorMessage(input.parentElement, "lg_err_sub_exist", "item__error");
		itemNameIsCorrect = false;
	}
	
	return itemNameIsCorrect;
}


/**
 * Removing HTML element.
 * @param element - element which needs to be removed.
**/
function deleteElement(element)
{
	element.remove();
}


/**
 * Checking length of string.
 * @param value - string for checking.
 * @param min - minimum allowable length.
 * @param max - maximum allowable length.
 * @returns result of checking. true - length is allowed, false - length not allowed.
**/
function isLengthMatch(value, min, max)
{
	return value.length >= min && value.length <= max;
}


/**
 * Checking string for letters only.
 * @param value - string for checking.
 * @returns result of checking. true - string contains only letters, 
 * 								false - length not allowed.
**/
function isOnlyLetters(value)
{
    var checkValue = /^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+$/g;
    
    return checkValue.test(value);
}


/**
 * Checking string for letters and numbers only.
 * @param value - string for checking.
 * @returns result of checking. true - the string contains only letters and numbers, 
 * 								false - length not allowed.
**/
function isOnlyLettersNums(value)
{
    var checkValue = /^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż0-9\s]+$/g;
    
    return checkValue.test(value);
}


/**
 * Checking email format.
 * @param value - string for checking.
 * @returns result of checking. true - email address is correct, 
 * 								false - email address isn't correct.
**/
function isEmailFormat(value)
{
    var checkValue = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    
    return checkValue.test(value);
}


/**
 * Checking repeated of elements.
 *  @param value - string for checking.
 * @param - list with elements
 * @returns result of checking. true - element is repeated, 
 * 								false - element isn't repeated.
**/
function checkRepeatedItem(value, itemsList)
{
	if(itemsList.length === 0)
	{
		return false;
	}
	else
	{
		if(itemsList.some(el => el.innerText.toLowerCase() === value.toLowerCase()))
		{
			return true;
		}
		return false;
	}
}


/**
 * Checking unique of element.
 * @param item - element for checking.
 * @param - list with existing elements.
 * @returns result of checking. true - element is unique, 
 * 								false - element isn't unique.
**/
function checkUniqueItem(value, itemsList)
{
	if(itemsList.length === 0)
	{
		return true;
	}
	else
	{
		if(itemsList.some(el => el.innerText.toLowerCase() === value.toLowerCase()))
		{
			return false;
		}
		return true;
	}
}



function handleSubjectsChange(kidName)
{
	var errorDivs = document.getElementsByClassName("item__error");
	removeListElements(errorDivs);
	
	var subjects = document.getElementsByClassName("item__new");
	if(subjects.length == 0)
	{
		var element = document.getElementById("formSubject");
		addErrorMessage(element, 'lg_err_no_new_sub', "item__error");
	}
	else
	{
		var subjectsList = [];
		for(var i=0; i<subjects.length; i++) 
		{
			subjectsList.push(subjects[i].innerText);
		}
		addSubjects(kidName, subjectsList);
		document.getElementById("subjects").innerHTML = getSubjectBlock(kidName);
	}
	
}


/**
 * Getting html code of subject block from server.
 * @param kidName - name of the kid.
 * @returns  html code of subject block from server.
**/
function getSubjectBlock(kidName)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
	    if (this.readyState === 4 && this.status !== 200)
	    {
	        throw JSON.parse(this.responseText).message;
	    }
	};
	xhttp.open("GET", "/gaintimeoff/subjecttemplate/subjects?kidName="+kidName, false);
	xhttp.send();
	
	return xhttp.responseText;
}


/**
 * Adding new Subject to database.
 * @param kidName - name of the kid.
 * @param subjects - list with new subjects.
**/
function addSubjects(kidName, subjects)
{
	var subjectsJSON = JSON.stringify(subjects);
	
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
    	if (this.readyState === 4 && this.status !== 200)
        {
            throw JSON.parse(this.responseText).message;
        }
    };
    xhttp.open("POST", "/gaintimeoff/restsubject/do-adding-subject", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidName="+kidName+"&subjects="+subjectsJSON);
}

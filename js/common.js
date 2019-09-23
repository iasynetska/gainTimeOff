var arrItemsKid = new Map();
var arrMessages = new Map();  
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


//////////////////////**********COMMON FUNCTIONS***************////////////////////////


/**
 * Adding border style.
 * @param element - HTML element.
**/
function addRedBorderStyle(element)
{
	element.style.border = "1px solid red";
}


/**
 * Deleting border style.
 * @param element - HTML element.
**/
function deleteBorderStyle(element)
{
   element.style.border = null;
}


/**
 * Deleting HTML element.
 * @param element - element which needs to be deleted.
**/
function deleteElement(element)
{
	element.remove();
}


/**
 * Deleting elements from HTMLCollection.
 * @param elements - array with elements.
**/
function deleteListElements(elements)
{
    while (elements.length > 0)
    {
    	elements[0].remove();
    }
}


/**
 * Checking length of text.
 * @param text - string for checking.
 * @param min - minimum allowable length.
 * @param max - maximum allowable length.
 * @returns result of checking. true - length of text is allowed, 
 * 								false - length of text not allowed.
**/
function isLengthMatch(text, min, max)
{
	return text.length >= min && text.length <= max;
}


/**
 * Checking text for letters only.
 * @param text - string for checking.
 * @returns result of checking. true - text contains only letters, 
 * 								false - text contains not allowed symbols.
**/
function isOnlyLetters(text)
{
    var checkText = /^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+$/g;
    
    return checkText.test(text);
}


/**
 * Checking text for letters and numbers only.
 * @param text - string for checking.
 * @returns result of checking. true - text contains only letters and numbers, 
 * 								false - text contains not allowed symbols.
**/
function isOnlyLettersNums(text)
{
    var checkText = /^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż0-9\s]+$/g;
    
    return checkText.test(text);
}


/**
 * Checking email format.
 * @param email - string for checking.
 * @returns result of checking. true - email address is correct, 
 * 								false - email address isn't correct.
**/
function isEmailFormat(email)
{
    var checkEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    
    return checkEmail.test(email);
}


/**
 * Checking time format.
 * @param element - HTML element.
 * @returns result of checking. true - time is correct, 
 * 								false - time isn't correct.
**/
function isTimeFormat(element)
{
	var timeFormatIsCorrect = true;
	var checkValue = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/;
	
	if(element.value === "")
	{
		addRedBorderStyle(element);
		addMessage(element.parentElement, "lg_err_empty", "item__error");
		timeFormatIsCorrect = false;
	}
	else if(!checkValue.test(element.value))
	{
		addRedBorderStyle(element);
		addMessage(element.parentElement, "lg_err_time", "item__error");
		timeFormatIsCorrect = false;
	}
	
	return timeFormatIsCorrect;
}


/**
 * Adding error message to submitted form
 * @param element - element for checking.
 * @param messageName - name of the error found.
 * @param className - name of class for message.
**/
function addMessage(element, messageName, className)
{      
   var divError = document.createElement("div");
   divError.setAttribute("id", "err_"+element.id);
   divError.setAttribute("class", className);
   element.parentNode.appendChild(divError);
   
   try 
   {
       divError.innerText = getMessage(messageName);
   }
   catch(exception)
   {
       divError.innerText = exception;
   }
}


/**
 * Getting text error message from server in the selected language by AJAX request.
 * @param messageName - name of the error.
 * @returns text error message from server in the selected language.
**/
function getMessage(messageName)
{
   if(arrMessages.has(messageName))
   {
       return arrMessages.get(messageName);
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
       xhttp.open("GET", "/gaintimeoff/message/get?messageName="+messageName, false);
       xhttp.send();

       var messageObject = JSON.parse(xhttp.responseText);
       arrMessages.set(messageName, messageObject.message);
       return messageObject.message;
   }
}


//////////////////////**********VALIDATION***************////////////////////////


/**
 * Checking fields of forms.
 * @param formId - id of submitted form.
 * @returns Result of validation. true - valid, 
 * 								  false - not valid.
 */
function validateForm(formId)
{
    var form = document.getElementById(formId);
    
    var errorDivs = form.getElementsByClassName("form__error");
    deleteListElements(errorDivs);
        
    var fieldsValid = validateFormInputs(form);
    var reCaptchaValid = validateFormReCaptcha();
    var radioSelected = validateRadioButtons(form);
    
    return fieldsValid && reCaptchaValid && radioSelected;
}


/**
  * Checking input fields of submitted form (without button element)
  * @param form - submitted form element.
  * @returns Result of validation.  true - valid, 
  * 								false - not valid.
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
                addMessage(element, "lg_err_empty_field", "form__error");
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
                        addMessage(element, "lg_err_length_2to20", "form__error");
                        valid = false;
                    }
                	else if(!isOnlyLetters(element.value))
                    {
                        addRedBorderStyle(element);
                        addMessage(element, "lg_err_letters", "form__error");
                        valid = false;
                    }
                    break;
                    
                case "login":
                    if(!isLengthMatch(element.value, 2, 20))
                    {
                        addRedBorderStyle(element);
                        addMessage(element, "lg_err_length_3to20", "form__error");
                        valid = false;
                    }
                    else if(!isOnlyLettersNums(element.value))
                    {
                        addRedBorderStyle(element);
                        addMessage(element, "lg_err_alnum", "form__error");
                        valid = false;
                    }
                    break;
                    
                case "email":
                    if(!isEmailFormat(element.value))
                    {
                        addRedBorderStyle(element);
                        addMessage(element, "lg_err_email", "form__error");
                        valid = false;
                    }
                    break;
                    
                case "password":
                    if(!isLengthMatch(element.value, 8, 20))
                    {
                        addRedBorderStyle(element);
                        addMessage(element, "lg_err_length_8to20", "form__error");
                        valid = false;
                    }
                    break;
                    
                case "confirmPassword":
                    var password = document.getElementById("password").value;
                    var confirmPassword = element.value;
                    if(password !== confirmPassword)
                    {
                        addRedBorderStyle(element);
                        addMessage(element, "lg_err_confirm_password", "form__error");
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
  * @returns Result of validation. true - valid, 
  * 							   false - not valid.
 **/
function validateFormReCaptcha()
{
    var valid = true; 
    var reCaptcha = document.getElementById("reCaptcha");
    
    if(reCaptcha !== null)
    {
        if(!reCaptchaSelected)
        {
            addMessage(reCaptcha, "lg_err_captcha", "form__error");
            valid = false;
        }
    }
    return valid;
}


/**
 * Checking fields of forms.
 * @param form - submitted form.
 * @returns Result of validation. true - valid, 
 * 								  false - not valid.
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
            addMessage(radioButtonsWithSameName[0], "lg_err_check_option", "form__error");
            valid = false;
        }
    }
    
    return valid;
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


//////////////////////**********PARENT'S DASHBOARD PAGE***************////////////////////////

/**
 * Getting all block of the first kid
**/

function getFirstKidBlocks()
{
	var kidsBlock = document.getElementById("kidsBlock");
	if(kidsBlock)
	{
		var kidName = kidsBlock.firstElementChild.id;
		var kidTimeBlock = document.getElementById("kidTimeBlock").innerHTML;
		var kidSubjectBlock = document.getElementById("kidSubjectBlock").innerHTML;
		var kidTaskBlock = document.getElementById("kidTaskBlock").innerHTML;
		
		addObjectToArrItemsKid(kidName, kidTimeBlock, kidSubjectBlock, kidTaskBlock);
	}
}


/**
 * Moving class = "active-profile" among kids on the Dasboard of parent page.
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
    
    getKidItemsBlock(kidElement.id);
}


/**
 * Get all blocks(Time, Subject, Task) with data of selected kid.
 * @param kidName - name of selected kid.
 */
function getKidItemsBlock(kidName)
{
	if(arrItemsKid.has(kidName))
    {
		document.getElementById("kidTimeBlock").innerHTML = arrItemsKid.get(kidName).kidTimeBlock;
		document.getElementById("kidSubjectBlock").innerHTML = arrItemsKid.get(kidName).kidSubjectBlock;
		document.getElementById("kidTaskBlock").innerHTML = arrItemsKid.get(kidName).kidTaskBlock;
    }
	else
	{
		var kidTimeBlock = getKidTimeBlock(kidName);
		document.getElementById("kidTimeBlock").innerHTML = kidTimeBlock;
		
		var kidSubjectBlock = getKidSubjectBlock(kidName);
		document.getElementById("kidSubjectBlock").innerHTML = kidSubjectBlock;
		
		var kidTaskBlock = getKidTaskBlock(kidName);
		document.getElementById("kidTaskBlock").innerHTML = kidTaskBlock;
		
		addObjectToArrItemsKid(kidName, kidTimeBlock, kidSubjectBlock, kidTaskBlock);
	}
}


/**
 * Get Time block of kid by AJAX request.
 * @param kidName - name of kid.
 * @returns HTML code of Time block.
 */
function getKidTimeBlock(kidName)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
	    if (this.readyState === 4 && this.status !== 200)
	    {
	        throw JSON.parse(this.responseText).message;
	    }
	};
	xhttp.open("GET", "/gaintimeoff/timeblock/get-dashboard-time-block?kidName="+kidName, false);
	xhttp.send();
	
	return xhttp.responseText;
}


/**
 * Get Subject block of kid by AJAX request.
 * @param kidName - name of kid.
 * @returns HTML code of Subject block.
 */
function getKidSubjectBlock(kidName)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
	    if (this.readyState === 4 && this.status !== 200)
	    {
	        throw JSON.parse(this.responseText).message;
	    }
	};
	xhttp.open("GET", "/gaintimeoff/subjectblock/get-dashboard-subject-block?kidName="+kidName, false);
	xhttp.send();
	
	return xhttp.responseText;
}


/**
 * Get Task block of kid by AJAX request.
 * @param kidName - name of kid.
 * @returns HTML code of Task block.
 */
function getKidTaskBlock(kidName)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
	    if (this.readyState === 4 && this.status !== 200)
	    {
	        throw JSON.parse(this.responseText).message;
	    }
	};
	xhttp.open("GET", "/gaintimeoff/taskblock/get-dashboard-task-block?kidName="+kidName, false);
	xhttp.send();
	
	return xhttp.responseText;
}


/**
 * Adding new kid's object to array arrItemsKid.
 * @param kidName - name of kid.
 * @param kidTimeBlock - HTML code of Time block.
 * @param kidSubjectBlock - HTML code of Subject block.
 * @param kidTaskBlock - HTML code of Task block.
 */
function addObjectToArrItemsKid(kidName, kidTimeBlock, kidSubjectBlock, kidTaskBlock)
{
	var kidItems = {
		  'kidTimeBlock': kidTimeBlock,
		  'kidSubjectBlock': kidSubjectBlock,
		  'kidTaskBlock': kidTaskBlock
		};
	
	arrItemsKid.set(kidName, kidItems);
}


/**
 * Adding got mark of kid.
 * @param kidName - name of kid.
 */
function addGotMark(kidName)
{
	var subjectBlock = document.getElementById("kidSubjectBlock");
	var errorDivs = kidSubjectBlock.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	var subjectsList = document.getElementById("subjectsList");
	var selectedSubject = subjectsList.value;
	
	var marksListDiv = document.getElementById("marksList");
	var marks = document.getElementsByName("mark");
	var selectedMark = null;
	
	for(var i=0; i<marks.length; i++)
	{
		if(marks[i].checked)
		{
			var selectedMark = marks[i].value;
			break;
		}
	}
	
	if(selectedSubject !== "0" && selectedMark !== null)
	{
		saveGotMark(kidName, selectedSubject, selectedMark);
		var kidTimeBlock = getKidTimeBlock(kidName);
		document.getElementById("kidTimeBlock").innerHTML = kidTimeBlock;
		arrItemsKid.get(kidName).kidTimeBlock = kidTimeBlock;
		subjectsList.selectedIndex = 0;
		for(var i=0; i<marks.length; i++)
		{
			marks[i].checked = false;
			break;
		}
		
	}
	else
	{
		showMessageIfSubjectNotSelected(subjectsList, selectedSubject);
		showMessageIfMarkNotSelected(marksListDiv, selectedMark);
	}
}


/**
 * Show warning message if Subject isn't selected.
 * @param subjectsList - all existing kid's subjects.
 * @param selectedSubject - selected subject.
 */
function showMessageIfSubjectNotSelected(subjectsList, selectedSubject)
{
	if(selectedSubject === "0")
	{
		addRedBorderStyle(subjectsList);
		addMessage(subjectsList.parentElement, 'lg_err_select_subject', "item__error");
	}
}


/**
 * Show warning message if Mark isn't selected.
 * @param marksListDiv - HTML element which consists all existing kid's marks.
 * @param selectedMark - selected mark.
 */
function showMessageIfMarkNotSelected(marksListDiv, selectedMark)
{
	if(selectedMark === null)
	{
		addRedBorderStyle(marksListDiv);
		addMessage(marksListDiv.parentElement, 'lg_err_select_mark', "item__error");
	}
}


/**
 * Saving new got mark to database.
 * @param kidName - name of kid.
 * @param subjectName - name of subject.
 * @param markName - name of mark.
 */
function saveGotMark(kidName, subjectName, markName)
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
    	if (this.readyState === 4 && this.status !== 200)
        {
            throw JSON.parse(this.responseText).message;
        }
    };
    xhttp.open("POST", "/gaintimeoff/restmark/save-got-mark", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidName="+kidName+"&subjectName="+subjectName+"&markName="+markName);
}


/**
 * Adding complited task of kid.
 * @param kidName - name of kid.
 */
function addComplitedTask(kidName)
{
	var taskBlock = document.getElementById("kidTaskBlock");
	var errorDivs = taskBlock.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	var tasksList = document.getElementById("tasksList");
	var selectedTask = tasksList.value;
	
	if(selectedTask === "0")
	{
		addRedBorderStyle(tasksList);
		addMessage(tasksList.parentElement, 'lg_err_select_task', "item__error");
	}
	else
	{
		saveComplitedTask(kidName, selectedTask);
		var kidTimeBlock = getKidTimeBlock(kidName);
		document.getElementById("kidTimeBlock").innerHTML = kidTimeBlock;
		arrItemsKid.get(kidName).kidTimeBlock = kidTimeBlock;
		tasksList.selectedIndex = 0;
	}
}


/**
 * Saving new complited task to database.
 * @param kidName - name of kid.
 * @param taskName - name of task.
 */
function saveComplitedTask(kidName, taskName)
{	
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
    	if (this.readyState === 4 && this.status !== 200)
        {
            throw JSON.parse(this.responseText).message;
        }
    };
    xhttp.open("POST", "/gaintimeoff/resttask/save-complited-task", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidName="+kidName+"&taskName="+taskName);
}


/**
 * Handler of kid's time for play.
 * @param kidName - name of kid.
 */
function handlerTimePlay(kidName)
{
	var kidTimeBlock = document.getElementById("kidTimeBlock");
	var errorDivs = kidTimeBlock.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	var inputTime = document.getElementById("inputTime");
	inputTime.value = inputTime.value.trim();
	
	if(isTimeFormat(inputTime))
	{
		saveTimePlayed(kidName, inputTime.value);
		var kidTimeBlock = getKidTimeBlock(kidName);
		document.getElementById("kidTimeBlock").innerHTML = kidTimeBlock;
		arrItemsKid.get(kidName).kidTimeBlock = kidTimeBlock;
	}
}


/**
 * Saving played time to database.
 * @param kidName - name of kid.
 * @param timePlayed - time play of kid.
 */
function saveTimePlayed(kidName, timePlayed)
{	
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
    	if (this.readyState === 4 && this.status !== 200)
        {
            throw JSON.parse(this.responseText).message;
        }
    };
    xhttp.open("POST", "/gaintimeoff/resttime/save-time-played", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidName="+kidName+"&timePlayed="+timePlayed);
}


/**
 * Handler of deleting of kid.
 * @param kidName - name of kid.
 */
function handlerDeletingProfile(kidName)
{
    if (confirm(getMessage("lg_confirm_delete")))
    {
        deleteKidProfile(kidName);
        var kidBlock = getKidBlock();
        if(kidBlock !== '')
    	{
        	document.getElementById("kidsBlock").innerHTML = getKidBlock();
            getKidItemsBlock(document.getElementById("kidsBlock").firstElementChild.id);
    	}
        else
    	{
            window.location.href = "/gaintimeoff/parent/dashboard";
    	}
    }
}


/**
 * Deleting Kid profile and his relatives.
 * @param kidName - name of kid.
 */
function deleteKidProfile(kidName)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState === 4 && this.status === 200)
        {
        	
        };
    };
    xhttp.open("POST", "/gaintimeoff/restkid/do-deleting-kid", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidName="+kidName);
};


/**
 * Getting html code of kid's block from server.
 * @returns  html code of kid's block from server.
**/
function getKidBlock()
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
	    if (this.readyState === 4 && this.status !== 200)
	    {
	        throw JSON.parse(this.responseText).message;
	    }
	};
	xhttp.open("GET", "/gaintimeoff/kidblock/get-dashboard-kid-block", false);
	xhttp.send();
	
	return xhttp.responseText;
}


//////////////////////**********ADDING NEW SUBJECTS/MARKS/TASKS***************////////////////////////


/**
 * Creating new subject element into list of subjects.
 * Before processing value is trimmed
 * @param inputId - id of input element which get name of new subject.
**/
function createNewSubElement(inputId)
{	
	var blockForm = document.getElementById(inputId).parentElement.parentElement;
	var errorDivs = blockForm.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	var input = document.getElementById(inputId);
	input.value = input.value.trim();
	
	if(checkItemName(input))
	{
		var ul = document.getElementById("subNewList");
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
 * Creating new element into list of tasks/marks.
 * Before processing value is trimmed
 * @param inputId - id of input element which get name of new subject.
**/
function createNewElement(itemIdInput, timeIdInput)
{
	var blockForm = document.getElementById(itemIdInput).parentElement.parentElement;
	var errorDivs = blockForm.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	var inputItem = document.getElementById(itemIdInput);
	inputItem.value = inputItem.value.trim();
	
	var inputTime = document.getElementById(timeIdInput);
	inputTime.value = inputTime.value.trim();
	
	if(checkItemName(inputItem) && isTimeFormat(inputTime))
	{
		var ul = document.getElementById("itemList");
		var li = document.createElement("li"); 
		li.classList.add("item__new");
 		var value = inputItem.value + " " + "\u2192" + " "+ inputTime.value;
		li.appendChild(document.createTextNode(value));
		var img = document.createElement("img");
		img.src = "/gaintimeoff/img/delete-16.png";
		img.addEventListener("click", function() {
			deleteElement(this.parentElement);
		});
		li.appendChild(img);
		ul.appendChild(li); 
		inputItem.value = "";
		inputTime.value = "";
	}
}


/**
 * Checking name of new element.
 * @param input - input element which get name of new item.
 * @returns result of checking. true - check was successful, false - check failed.
**/
function checkItemName(input)
{
	var itemNameIsCorrect = true;
	
	var newItems = document.getElementsByClassName("item__new");
	var newItemsArr = Array.from(newItems);
	
	var existingItems = document.getElementsByClassName("item-list__existing");
	var existingItemsArr = Array.from(existingItems);
	
	if(!isLengthMatch(input.value, input.min, input.max))
	{
		addRedBorderStyle(input);
		addMessage(input.parentElement, input.min==="1"?"lg_err_length_1to2":"lg_err_length_2to20", "item__error");
		itemNameIsCorrect = false;
	}
	else if(!isOnlyLettersNums(input.value))
	{
		addRedBorderStyle(input);
		addMessage(input.parentElement, "lg_err_alnum", "item__error");
		itemNameIsCorrect = false;
	}
	else if(checkRepeatedItem(input.value, newItemsArr))
	{		
		addRedBorderStyle(input);
		addMessage(input.parentElement, "lg_err_el_replay", "item__error");
		itemNameIsCorrect = false;
	}
	else if(!checkUniqueItem(input.value, existingItemsArr))
	{
		addRedBorderStyle(input);
		addMessage(input.parentElement, "lg_err_el_exist", "item__error");
		itemNameIsCorrect = false;
	}
	
	return itemNameIsCorrect;
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
		if(itemsList.some(el => el.innerText.split("\u2192")[0].trim().toLowerCase() === value.toLowerCase()))
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


/**
 * Handler of adding new kid's Subjects.
 * @param kidName - name of kid.
 */
function handlerSavingNewSubjects(kidName)
{
	var errorDivs = document.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	var subjects = document.getElementsByClassName("item__new");
	if(subjects.length == 0)
	{
		var element = document.getElementById("formSubject");
		addMessage(element, 'lg_err_no_new_el', "item__error");
	}
	else
	{
		var subjectsList = [];
		for(var i=0; i<subjects.length; i++) 
		{
			subjectsList.push(subjects[i].innerText);
		}
		saveSubjects(kidName, subjectsList);
		document.getElementById("subjects").innerHTML = getSubjectBlock(kidName);
	}
	
}


/**
 * Saving new Subjects to database.
 * @param kidName - name of the kid.
 * @param subjects - list with new subjects.
**/
function saveSubjects(kidName, subjects)
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
    xhttp.open("POST", "/gaintimeoff/restsubject/do-saving-subject", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidName="+kidName+"&subjects="+subjectsJSON);
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
	xhttp.open("GET", "/gaintimeoff/subjectblock/get-adding-subject-block?kidName="+kidName, false);
	xhttp.send();
	
	return xhttp.responseText;
}


/**
 * Handler of adding new kid's Marks.
 * @param kidName - name of kid.
 */
function handlerSavingNewMarks(kidName)
{
	var errorDivs = document.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	var marks = document.getElementsByClassName("item__new");
	if(marks.length == 0)
	{
		var element = document.getElementById("formMark");
		addMessage(element, 'lg_err_no_new_el', "item__error");
	}
	else
	{
		var marksList = [];
		for(var i=0; i<marks.length; i++) 
		{
			var markName = marks[i].innerText.split("\u2192")[0].trim();
			var markTime = marks[i].innerText.split("\u2192")[1].trim();
			
			var mark = new Object();
			mark.name = markName;
			mark.gameTime = markTime;
			marksList.push(mark);
		}
		saveMarks(kidName, marksList);
		document.getElementById("marks").innerHTML = getMarkBlock(kidName);
	}
	
}


/**
 * Saving new Marks to database.
 * @param kidName - name of the kid.
 * @param marks - list with new marks.
**/
function saveMarks(kidName, marks)
{
	var marksJSON = JSON.stringify(marks);
	
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
    	if (this.readyState === 4 && this.status !== 200)
        {
            throw JSON.parse(this.responseText).message;
        }
    };
    xhttp.open("POST", "/gaintimeoff/restmark/do-saving-mark", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidName="+kidName+"&marks="+marksJSON);
}


/**
 * Getting html code of mark block from server by AJAX request.
 * @param kidName - name of the kid.
 * @returns  html code of mark block from server.
**/
function getMarkBlock(kidName)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
	    if (this.readyState === 4 && this.status !== 200)
	    {
	        throw JSON.parse(this.responseText).message;
	    }
	};
	xhttp.open("GET", "/gaintimeoff/markblock/get-adding-mark-block?kidName="+kidName, false);
	xhttp.send();
	
	return xhttp.responseText;
}


/**
 * Handler of adding new kid's Tasks.
 * @param kidName - name of kid.
 */
function handlerSavingNewTasks(kidName)
{
	var errorDivs = document.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	var tasks = document.getElementsByClassName("item__new");
	if(tasks.length == 0)
	{
		var element = document.getElementById("formTask");
		addMessage(element, 'lg_err_no_new_el', "item__error");
	}
	else
	{
		var tasksList = [];
		for(var i=0; i<tasks.length; i++) 
		{
			var taskName = tasks[i].innerText.split("\u2192")[0].trim();
			var taskTime = tasks[i].innerText.split("\u2192")[1].trim();
			
			var task = new Object();
			task.name = taskName;
			task.gameTime = taskTime;
			tasksList.push(task);
		}
		saveTasks(kidName, tasksList);
		document.getElementById("tasks").innerHTML = getTaskBlock(kidName);
	}
	
}


/**
 * Adding new Task to database.
 * @param kidName - name of the kid.
 * @param tasks - list with new tasks.
**/
function saveTasks(kidName, tasks)
{
	var tasksJSON = JSON.stringify(tasks);
	
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
    	if (this.readyState === 4 && this.status !== 200)
        {
            throw JSON.parse(this.responseText).message;
        }
    };
    xhttp.open("POST", "/gaintimeoff/resttask/do-saving-task", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidName="+kidName+"&tasks="+tasksJSON);
}


/**
 * Getting html code of task block from server by AJAX request.
 * @param kidName - name of the kid.
 * @returns  html code of task block from server.
**/
function getTaskBlock(kidName)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
	    if (this.readyState === 4 && this.status !== 200)
	    {
	        throw JSON.parse(this.responseText).message;
	    }
	};
	xhttp.open("GET", "/gaintimeoff/taskblock/get-adding-task-block?kidName="+kidName, false);
	xhttp.send();
	
	return xhttp.responseText;
}



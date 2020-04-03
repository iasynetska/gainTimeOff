const arrItemsKid = new Map();
const arrMessages = new Map();
let reCaptchaSelected = false;


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
    const width = $( ".g-recaptcha" ).parent().width();
    let scale;
  
  if (width < 302) {
      scale = width / 302;
  } else {
      scale = 1;
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
 * @returns boolean of checking. true - text contains only letters,
 * 								false - text contains not allowed symbols.
**/
function isOnlyLetters(text)
{
    const textFormat = /^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+$/g;
    
    return textFormat.test(text);
}


/**
 * Checking text for letters and numbers only.
 * @param text - string for checking.
 * @returns boolean of checking. true - text contains only letters and numbers,
 * 								false - text contains not allowed symbols.
**/
function isOnlyLettersNums(text)
{
    const textFormat = /^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż0-9\s]+$/g;
    
    return textFormat.test(text);
}


/**
 * Checking email format.
 * @param email - string for checking.
 * @returns boolean of checking. true - email address is correct,
 * 								false - email address isn't correct.
**/
function isEmailFormatCorrectly(email)
{
    const emailFormat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    
    return emailFormat.test(email);
}


/**
 * Checking time format.
 * @param element - HTML element.
 * @returns boolean of checking. true - time is correct,
 * 								false - time isn't correct.
**/
function isTimeValidForSave(element)
{
	let timeFormatIsCorrect = true;
	const timeFormat = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/;
	
	if(element.value === "")
	{
		addRedBorderStyle(element);
		addMessage(element.parentElement, "lg_err_empty", "item__error");
		timeFormatIsCorrect = false;
	}
	else if(!timeFormat.test(element.value))
	{
		addRedBorderStyle(element);
		addMessage(element.parentElement, "lg_err_time", "item__error");
		timeFormatIsCorrect = false;
	}
	else if(element.value === "00:00")
	{
		addRedBorderStyle(element);
		addMessage(element.parentElement, "lg_err_time_zero", "item__error");
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
   const divError = document.createElement("div");
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
       const xhttp = new XMLHttpRequest();
       xhttp.onreadystatechange = function() 
       {
           if (this.readyState === 4 && this.status !== 200)
           {
               throw JSON.parse(this.responseText).message;
           }
       };
       xhttp.open("GET", "/gaintimeoff/message/get?messageName="+messageName, false);
       xhttp.send();

       const messageObject = JSON.parse(xhttp.responseText);
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
    const form = document.getElementById(formId);
    
    const errorDivs = form.getElementsByClassName("form__error");
    deleteListElements(errorDivs);
        
    const fieldsValid = validateFormInputs(form);
    const reCaptchaValid = validateFormReCaptcha();
    const radioSelected = validateRadioButtons(form);
    
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
    let valid = true;
    const formElements = form.elements;
    
    for(let i=0; i<formElements.length; i++)
    {
        let element = formElements.item(i);
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
                    if(!isEmailFormatCorrectly(element.value))
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
                    const password = document.getElementById("password").value;
                    const confirmPassword = element.value;
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
  * @returns boolean of validation. true - valid,
  * 							   false - not valid.
 **/
function validateFormReCaptcha()
{
    let valid = true;
    const reCaptcha = document.getElementById("reCaptcha");
    
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
 * @returns boolean of validation. true - valid,
 * 								  false - not valid.
 */
function validateRadioButtons(form)
{
    let valid = true;
    const formElements = form.elements;
    const radioButtons = new Map();
    
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
        let selected = false;
        for (let j=0; j<radioButtonsWithSameName.length; j++)
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
    const fileReal = document.getElementById("add-file__real");
    fileReal.click();
}


/**
 * Creating the name of the attached file.
**/
function addFileName()
{
    const fileReal = document.getElementById("add-file__real");
    const fileTxt = document.getElementById("add-file__text");
    const fileTxtValue = document.getElementById("add-file__text").textContent;
    
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
    const inputFile = document.getElementById("add-file__real");
    const fileTxt = document.getElementById("add-file__text");
    inputFile.value = "";
    fileTxt.innerHTML = "&hellip;";
}


//////////////////////**********PARENT'S DASHBOARD PAGE***************////////////////////////

/**
 * Getting all block of the first kid
**/

function getFirstKidBlocks()
{
	const kidsBlock = document.getElementById("kidsBlock");
	if(kidsBlock)
	{
		const kidName = kidsBlock.firstElementChild.id;
		const kidTimeBlock = document.getElementById("kidTimeBlock").innerHTML;
		const kidSubjectBlock = document.getElementById("kidSubjectBlock").innerHTML;
		const kidTaskBlock = document.getElementById("kidTaskBlock").innerHTML;
		const kidReportReceivedMarksBlock = document.getElementById("kidReportReceivedMarksBlock").innerHTML;

		addObjectToArrItemsKid(kidName, kidTimeBlock, kidSubjectBlock, kidTaskBlock, kidReportReceivedMarksBlock);
	}
}


/**
 * Moving class = "active-profile" among kids on the Dasboard of parent page.
 * @param kidElement - HTML element of selected kid.
**/
function moveActiveProfile(kidElement)
{
    const kids = document.getElementsByClassName("kid");
    for(let i=0; i<kids.length; i++)
    {
        kids[i].classList.remove("active-profile");
    }

    const newActiveProfile = kidElement;
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
		document.getElementById("kidReportReceivedMarksBlock").innerHTML = arrItemsKid.get(kidName).kidReportReceivedMarksBlock;
    }
	else
	{
		const kidTimeBlock = getKidTimeBlock(kidName);
		document.getElementById("kidTimeBlock").innerHTML = kidTimeBlock;
		
		const kidSubjectBlock = getKidSubjectBlock(kidName);
		document.getElementById("kidSubjectBlock").innerHTML = kidSubjectBlock;
		
		const kidTaskBlock = getKidTaskBlock(kidName);
		document.getElementById("kidTaskBlock").innerHTML = kidTaskBlock;

        const kidReportReceivedMarksBlock = getKidReportReceivedMarksBlock(kidName);
        document.getElementById("kidReportReceivedMarksBlock").innerHTML = kidReportReceivedMarksBlock;
		
		addObjectToArrItemsKid(kidName, kidTimeBlock, kidSubjectBlock, kidTaskBlock, kidReportReceivedMarksBlock);
	}
}


/**
 * Get Time block of kid by AJAX request.
 * @param kidName - name of kid.
 * @returns string html code of Time block.
 */
function getKidTimeBlock(kidName)
{
	const xhttp = new XMLHttpRequest();
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
 * @returns string html code of Subject block.
 */
function getKidSubjectBlock(kidName)
{
    const xhttp = new XMLHttpRequest();
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
 * @returns string html code of Task block.
 */
function getKidTaskBlock(kidName)
{
	const xhttp = new XMLHttpRequest();
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
 * Get report received marks block of kid by AJAX request.
 * @param kidName - name of kid.
 * @returns string html code of Mark block.
 */
function getKidReportReceivedMarksBlock(kidName, startDate='', endDate='')
{
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState === 4 && this.status !== 200)
        {
            throw JSON.parse(this.responseText).message;
        }
    };
    xhttp.open("GET", "/gaintimeoff/reportreceivedmarksblock/get-dashboard-report-received-marks-block?kidName="+kidName+"&startDate="+startDate+"&endDate="+endDate, false);
    xhttp.send();

    return xhttp.responseText;
}


function getReportReceivedMarks(kidName) {
    const kidReportReceivedMarksBlock = document.getElementById("kidReportReceivedMarksBlock");
    const errorDivs = kidReportReceivedMarksBlock.getElementsByClassName("item__error");
    deleteListElements(errorDivs);

    const monthsList = document.getElementById("monthsList");
    const selectedMonth = monthsList.value;

    const yearsList = document.getElementById("yearsList");
    const selectedYear = yearsList.value;

    if(selectedYear !== "0")
    {
        let startDate = [];
        let endDate = [];
        if(selectedMonth !== "0") {
            startDate = [selectedYear, selectedMonth, '01'];
            endDate = [selectedYear, parseInt(selectedMonth)+1, '01'];
        } else {
            startDate = [selectedYear, '01', '01'];
            endDate = [parseInt(selectedYear)+1, '01', '01'];
        }

        try {
            const reportReceivedMarksBlock = getKidReportReceivedMarksBlock(kidName, startDate.join("-"), endDate.join("-"));
            kidReportReceivedMarksBlock.innerHTML = reportReceivedMarksBlock;
            document.getElementById("monthsList").selectedIndex = selectedMonth;

            const yearsOptions = document.getElementById("yearsList").options;
            for(let i = 1; i<yearsOptions.length; i++) {
                yearsOptions[i].selected = false;
                if(yearsOptions[i].value === selectedYear) {
                    yearsOptions[i].selected = true;
                }
            }

            let x = 10;

        } catch(error) {
            alert(error);
        }
    }
    else
    {
        showMessageIfYearNotSelected(yearsList, selectedYear);
    }
}


/**
 * Show warning message if Year isn't selected.
 * @param yearsList - list of years.
 * @param selectedYear - selected year.
 */
function showMessageIfYearNotSelected(yearsList, selectedYear)
{
    if(selectedYear === "0")
    {
        addRedBorderStyle(yearsList);
        addMessage(yearsList.parentElement, 'lg_err_select_year', "item__error");
    }
}


/**
 * Adding new kid's object to array arrItemsKid.
 * @param kidName - name of kid.
 * @param kidTimeBlock - html code of Time block.
 * @param kidSubjectBlock - html code of Subject block.
 * @param kidTaskBlock - html code of Task block.
 */
function addObjectToArrItemsKid(kidName, kidTimeBlock, kidSubjectBlock, kidTaskBlock, kidReportReceivedMarksBlock)
{
	const kidItems = {
        'kidTimeBlock': kidTimeBlock,
        'kidSubjectBlock': kidSubjectBlock,
        'kidTaskBlock': kidTaskBlock,
        'kidReportReceivedMarksBlock': kidReportReceivedMarksBlock

    };
	
	arrItemsKid.set(kidName, kidItems);
}


/**
 * Adding received mark of kid.
 * @param kidName - name of kid.
 */
function addReceivedMark(kidName)
{
	const kidSubjectBlock = document.getElementById("kidSubjectBlock");
	const errorDivs = kidSubjectBlock.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	const subjectsList = document.getElementById("subjectsList");
	const selectedSubject = subjectsList.value;
	
	const marksListDiv = document.getElementById("marksList");
	const marks = document.getElementsByName("mark");
	let selectedMark = null;
	
	for(let i=0; i<marks.length; i++)
	{
		if(marks[i].checked)
		{
			selectedMark = marks[i].value;
			break;
		}
	}
	
	if(selectedSubject !== "0" && selectedMark !== null)
	{
		try
		{
			saveReceivedMark(kidName, selectedSubject, selectedMark);
			const kidTimeBlock = getKidTimeBlock(kidName);
			document.getElementById("kidTimeBlock").innerHTML = kidTimeBlock;
			arrItemsKid.get(kidName).kidTimeBlock = kidTimeBlock;
            const currentYear = new Date().getFullYear();
            const startDate = [currentYear, '01', '01'];
            const endDate = [currentYear+1, '01', '01'];
            const kidReportReceivedMarksBlock = getKidReportReceivedMarksBlock(kidName, startDate.join("-"), endDate.join("-"));
            document.getElementById("kidReportReceivedMarksBlock").innerHTML = kidReportReceivedMarksBlock;
			subjectsList.selectedIndex = 0;
			for(let i=0; i<marks.length; i++)
			{
			    if(marks[i].checked === true) {
                    marks[i].checked = false;
                    break;
                }
			}
		}
		catch(error)
		{
			alert(error);
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
 * Saving new received mark to database.
 * @param kidName - name of kid.
 * @param subjectName - name of subject.
 * @param markName - name of mark.
 */
function saveReceivedMark(kidName, subjectName, markName)
{
	const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "/gaintimeoff/restmark/save-received-mark", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidName="+kidName+"&subjectName="+subjectName+"&markName="+markName);
    if(xhttp.status!==200)
	{
    	throw JSON.parse(xhttp.responseText).message;
	}
}


/**
 * Adding completed task of kid.
 * @param kidName - name of kid.
 */
function addCompletedTask(kidName)
{
	const taskBlock = document.getElementById("kidTaskBlock");
	const errorDivs = taskBlock.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	const tasksList = document.getElementById("tasksList");
	const selectedTask = tasksList.value;
	
	if(selectedTask === "0")
	{
		addRedBorderStyle(tasksList);
		addMessage(tasksList.parentElement, 'lg_err_select_task', "item__error");
	}
	else
	{
		try
		{
			saveCompletedTask(kidName, selectedTask);
			const kidTimeBlock = getKidTimeBlock(kidName);
			document.getElementById("kidTimeBlock").innerHTML = kidTimeBlock;
			arrItemsKid.get(kidName).kidTimeBlock = kidTimeBlock;
			tasksList.selectedIndex = 0;
		}
		catch(error)
		{
			alert(error);
		}
	}
}


/**
 * Saving new completed task to database.
 * @param kidName - name of kid.
 * @param taskName - name of task.
 */
function saveCompletedTask(kidName, taskName)
{	
	const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "/gaintimeoff/resttask/save-completed-task", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidName="+kidName+"&taskName="+taskName);
    if(xhttp.status!==200)
	{
    	throw JSON.parse(xhttp.responseText).message;
	}
}


/**
 * Handler of kid's time for play.
 * @param kidName - name of kid.
 */
function handlerTimePlay(kidName)
{
	const errorDivs = kidTimeBlock.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	const inputTime = document.getElementById("inputTime");
	inputTime.value = inputTime.value.trim();
	
	try
	{
		if(isTimeValidForSave(inputTime))
		{
			saveTimePlayed(kidName, inputTime.value);
			const kidTimeBlock = getKidTimeBlock(kidName);
			document.getElementById("kidTimeBlock").innerHTML = kidTimeBlock;
			arrItemsKid.get(kidName).kidTimeBlock = kidTimeBlock;
		}
	}
	catch(error)
	{
		alert(error);
	}
	
}


/**
 * Saving played time to database.
 * @param kidName - name of kid.
 * @param timePlayed - time play of kid.
 */
function saveTimePlayed(kidName, timePlayed)
{	
	const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "/gaintimeoff/resttime/save-time-played", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidName="+kidName+"&timePlayed="+timePlayed);
    if(xhttp.status!==200)
	{
    	throw JSON.parse(xhttp.responseText).message;
	}
}


/**
 * Handler of deleting of kid.
 * @param kidName - name of kid.
 */
function handlerDeletingProfile(kidName)
{
    if (confirm(getMessage("lg_confirm_delete")))
    {
    	try
    	{
    		deleteKidProfile(kidName);
            const kidBlock = getKidBlock();
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
        catch(error)
        {
        	alert(error);
        }
    }
}


/**
 * Deleting Kid profile and his relatives.
 * @param kidName - name of kid.
 */
function deleteKidProfile(kidName)
{
    const xhttp = new XMLHttpRequest();

    xhttp.open("POST", "/gaintimeoff/restkid/do-deleting-kid", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidName="+kidName);
    if(xhttp.status!==200)
	{
    	throw JSON.parse(xhttp.responseText).message;
	}
    
}


/**
 * Getting html code of kid's block from server.
 * @returns  string html code of kid's block from server.
**/
function getKidBlock()
{
	const xhttp = new XMLHttpRequest();
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
	const blockForm = document.getElementById(inputId).parentElement.parentElement;
	const errorDivs = blockForm.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	const input = document.getElementById(inputId);
	input.value = input.value.trim();
	
	if(checkItemName(input))
	{
		const ul = document.getElementById("subNewList");
		const li = document.createElement("li");
		li.classList.add("item__new");
		li.appendChild(document.createTextNode(input.value));
		const img = document.createElement("img");
		img.src = "/img/delete-16.png";
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
 * @param itemIdInput
 * @param timeIdInput
**/
function createNewElement(itemIdInput, timeIdInput)
{
	const blockForm = document.getElementById(itemIdInput).parentElement.parentElement;
	const errorDivs = blockForm.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	const inputItem = document.getElementById(itemIdInput);
	inputItem.value = inputItem.value.trim();
	
	const inputTime = document.getElementById(timeIdInput);
	inputTime.value = inputTime.value.trim();
	
	if(checkItemName(inputItem) && isTimeValidForSave(inputTime))
	{
		const ul = document.getElementById("itemList");
		const li = document.createElement("li");
		li.classList.add("item__new");
 		const value = inputItem.value + " " + "\u2192" + " "+ inputTime.value;
		li.appendChild(document.createTextNode(value));
		const img = document.createElement("img");
		img.src = "/img/delete-16.png";
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
 * @returns boolean of checking. true - check was successful, false - check failed.
**/
function checkItemName(input)
{
	let itemNameIsCorrect = true;
	
	const newItems = document.getElementsByClassName("item__new");
	const newItemsArr = Array.from(newItems);
	
	const existingItems = document.getElementsByClassName("item-list__existing");
	const existingItemsArr = Array.from(existingItems);
	
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
 *  @param itemsList - list with elements
 * @returns boolean of checking. true - element is repeated,
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
 * @param value - element for checking.
 * @param itemsList - list with existing elements.
 * @returns boolean of checking. true - element is unique,
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
	const errorDivs = document.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	const subjects = document.getElementsByClassName("item__new");
	if(subjects.length == 0)
	{
		const element = document.getElementById("formSubject");
		addMessage(element, 'lg_err_no_new_el', "item__error");
	}
	else
	{
		const subjectsList = [];
		for(let i=0; i<subjects.length; i++)
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
	const subjectsJSON = JSON.stringify(subjects);
	
	const xhttp = new XMLHttpRequest();
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
 * @returns  string html code of subject block from server.
**/
function getSubjectBlock(kidName)
{
	const xhttp = new XMLHttpRequest();
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
	const errorDivs = document.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	const marks = document.getElementsByClassName("item__new");
	if(marks.length == 0)
	{
		const element = document.getElementById("formMark");
		addMessage(element, 'lg_err_no_new_el', "item__error");
	}
	else
	{
		const marksList = [];
		for(let i=0; i<marks.length; i++)
		{
			const markName = marks[i].innerText.split("\u2192")[0].trim();
			const markTime = marks[i].innerText.split("\u2192")[1].trim();
			
			const mark = new Object();
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
	const marksJSON = JSON.stringify(marks);
	
	const xhttp = new XMLHttpRequest();
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
 * @returns  string html code of mark block from server.
**/
function getMarkBlock(kidName)
{
	const xhttp = new XMLHttpRequest();
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
	const errorDivs = document.getElementsByClassName("item__error");
	deleteListElements(errorDivs);
	
	const tasks = document.getElementsByClassName("item__new");
	if(tasks.length == 0)
	{
		const element = document.getElementById("formTask");
		addMessage(element, 'lg_err_no_new_el', "item__error");
	}
	else
	{
		const tasksList = [];
		for(let i=0; i<tasks.length; i++)
		{
			const taskName = tasks[i].innerText.split("\u2192")[0].trim();
			const taskTime = tasks[i].innerText.split("\u2192")[1].trim();
			
			const task = new Object();
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
	const tasksJSON = JSON.stringify(tasks);
	
	const xhttp = new XMLHttpRequest();
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
 * @returns  string html code of task block from server.
**/
function getTaskBlock(kidName)
{
	const xhttp = new XMLHttpRequest();
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



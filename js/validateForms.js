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
 * Checking fields of forms.
 * @param formId - id of submitted form.
 * @returns Result of validation. true - valid, false - not valid.
 */
function validateForm(formId)
{
    var form = document.getElementById(formId);
    
    var errorDivs = form.getElementsByClassName("form__error");
    while (errorDivs.length > 0)
    {
        errorDivs[0].remove();
    }
        
    var fieldsValid = validateFormInputs(form);
    var reCaptchaValid = validateFormReCaptcha();
    var radioSelected = validateRadioButtons(form);
    var dateValid = validateDateField();
    
    return fieldsValid && reCaptchaValid && radioSelected && dateValid;
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
        
        if(element.value.trim() === "")
        {
            if (element.classList.contains("required"))
            {
                var errorName = "err_empty_field";
                element.style.border = "1px solid red";
                addErrorMessage(element, errorName);
                valid = false;
            }
        }
        else
        {
            switch(element.id)
            {
                case "name":
                    var name = element.value.trim();
                    var regName = /^[A-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+$/g;
                    if(!regName.test(name))
                    {
                        errorName = "err_name_letters";
                        element.style.border = "1px solid red";
                        addErrorMessage(element, errorName);
                        valid = false;
                    }
                    break;
                    
                case "login":
                    var login = element.value.trim();
                    var checkLogin = /^[A-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+$/g;
                    if(login.length < 3 || login.length > 20)
                    {
                        errorName = "err_login";
                        element.style.border = "1px solid red";
                        addErrorMessage(element, errorName);
                        valid = false;
                    }
                    else if(!checkLogin.test(login))
                    {
                        errorName = "err_alnum_login";
                        element.style.border = "1px solid red";
                        addErrorMessage(element, errorName);
                        valid = false;
                    }
                    break;
                    
                case "email":
                    var email = element.value.trim();
                    var regEmail = /^([A-z0-9_\-\.])+\@([A-z0-9_\-\.])+\.([A-z]{2,4})$/;
                    if(!regEmail.test(email))
                    {
                        errorName = "err_email";
                        element.style.border = "1px solid red";
                        addErrorMessage(element, errorName);
                        valid = false;
                    }
                    break;
                    
                case "password":
                    var password = element.value;
                    if(password.length < 8 || password.length > 20)
                    {
                        errorName = "err_password";
                        element.style.border = "1px solid red";
                        addErrorMessage(element, errorName);
                        valid = false;
                    }
                    break;
                    
                case "confirmPassword":
                    var password = document.getElementById("password").value;
                    var confirmPassword = element.value;
                    if(password !== confirmPassword)
                    {
                        errorName = "err_confirm_password";
                        element.style.border = "1px solid red";
                        addErrorMessage(element, errorName);
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
    var reCaptcha = document.getElementById('reCaptcha');
    
    if(reCaptcha !== null)
    {
        if(!reCaptchaSelected)
        {
            errorName = "err_captcha";
            addErrorMessage(reCaptcha, errorName);
            valid = false;
        }
    }
    return valid;
}

function validateRadioButtons(form)
{
    var valid = true;
    var formElements = form.elements;
    var radioButtons = new Map();
    
    for (var i=0; i<formElements.length; i++) 
    {
        if (formElements[i].type === 'radio') 
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
            errorName = "err_check_option";
            radioButtonsWithSameName[0].parentNode.style.border = "1px solid red";
            addErrorMessage(radioButtonsWithSameName[0], errorName);
            valid = false;
        }
    }
    
    return valid;
}

function validateDateField()
{
    var valid = true; 
    var inputtedDate  = document.getElementById('birthday');
    var regDate = /^((19|20)\d{2})[/|-]((0[1-9])|1[0-2])[/|-]((0[1-9]|[12][0-9]|3[0-1]))$/;
    
    if(inputtedDate.value !== "")
    {
        if(!regDate.test(inputtedDate.value.trim()))
        {
        errorName = "err_date";
        inputtedDate.style.border = "1px solid red";
        addErrorMessage(inputtedDate, errorName);
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
function addErrorMessage(element, errorName)
{      
    var divError = document.createElement("div");
    divError.setAttribute("id", "err_"+element.id);
    divError.setAttribute("class", "form__error");
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
                throw this.responseText;
            }
        };
        xhttp.open("GET", "services/error_message.php?errorName="+errorName, false);
        xhttp.send();
        arrErrorMessages.set(errorName, xhttp.responseText);

        return xhttp.responseText;
    }
}


/**
  * Removing border style.
  * @param id - id of element.
 **/
function removeBorder(id)
{
    document.getElementById(id).style.border = null;
}

function clickInputFile()
{
    var fileReal = document.getElementById("add-file__real");
    fileReal.click();
}

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

function clearFile()
{
    var inputFile = document.getElementById("add-file__real");
    var fileTxt = document.getElementById("add-file__text");
    inputFile.value = "";
    fileTxt.innerHTML = "&hellip;";
}
window.onload = changeCaptchaSize();
window.addEventListener("resize", changeCaptchaSize);

//Adaptive reCAPTCHA
function changeCaptchaSize() 
{
    var reCaptchaWidth = 302;
    var containerWidth = $(".register-parent").width();
    if(reCaptchaWidth !== containerWidth) 
    {
        var reCaptchaScale = containerWidth / reCaptchaWidth;
        $(".g-recaptcha").css(
        {
            "transform":"scale("+reCaptchaScale+")",
            "transform-origin":"0 0"
        });
    }
}


/**
 * Checking fields of login forms.
 * @param formId id of submitted form.
 * @param loginId id of login field.
 * @param passwordId id of password field.
 * @returns Result of validation. true - valid, false - not valid.
 */
function validateLoginForm(formId, loginId, passwordId)
{
    var valid = true;
    
    if(document.getElementById(loginId).value.trim() === "")
    {
        document.getElementById(loginId).style.border = "1px solid red";
        valid = false;
    }
    
    if(document.getElementById(passwordId).value === "")
    {
        document.getElementById(passwordId).style.border = "1px solid red";
        valid = false;
    }
    
    if(!valid)
    {
        var divError = document.getElementById("errorMessage");
        if(divError === null)
        {
            var divError = document.createElement("div");
            divError.setAttribute("id", "errorMessage");
            var btn = document.getElementById("subBtn");
            var form = document.getElementById(formId);
            form.insertBefore(divError, btn);
        }
        
        try 
        {
            var errorName = getErrorMessage("err_empty_fields");
            divError.innerText = errorName;
        }
        catch(error)
        {
            divError.innerText = error;
        }
    }
    
    return valid;
}


/**
 * @param errorName - name of error massage to get.
 * @returns error message.
 * @throws Exception if no such error name or other issue.
 */
function getErrorMessage(errorName)
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
    return xhttp.responseText;
}

//remove red border
function removeBorder(id)
{
    document.getElementById(id).style.border = null;
}

//Adding new kid (Choose file)
const fileReal = document.getElementById("add-file__real");
const fileBtn = document.getElementById("add-file__btn");
const fileTxt = document.getElementById("add-file__text");
const fileTxtValue = document.getElementById("add-file__text").textContent;

fileBtn.addEventListener("click", function() {
  fileReal.click();
});

fileReal.addEventListener("change", function() {
  if (fileReal.value) {
    fileTxt.innerHTML = fileReal.value.match(
      /[\/\\]([\w\d\s\.\-\(\)]+)$/
    )[1];
  } else {
    fileTxt.innerHTML = fileTxtValue;
  }
});


//Change active profile
function changeActiveProfile(idKid)
{
    var kids = document.getElementsByClassName("kid");
    for(var i=0; i<kids.length; i++)
    {
        kids[i].classList.remove("active-profile");
    }

    var newActiveProfile = document.getElementById(idKid);
    newActiveProfile.classList.add("active-profile");
}


//Confirmation box
function areYouSure(name)
{
    var lang = document.getElementById("active-link").text;
    if(lang==="En")
    {
        if (confirm("You really want to delete profile "+name+"?"))
        {
            deleteKid(name);
        }
    }
    else if(lang==="Pl")
    {
        if (confirm("Naprawdę chcesz usunąć profil "+name+"?"))
        {
            deleteKid(name);
        }
    }
};


//Delete Kid from database(dashboard_parent_kids.php)
function deleteKid(name)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState === 4 && this.status === 200)
        {
            var divKid = document.getElementById(name);
            divKid.parentNode.removeChild(divKid);
            alert(this.responseText);
        };
    };
    xhttp.open("GET", "services/do_delete_kid.php?name="+name, true);
    xhttp.send();
};


//Adding Subjects
function addSubject()
{
    var subject = document.getElementById("subject-new").value;
    
    var divMain = document.createElement('div');
    divMain.setAttribute("id", subject);
    divMain.setAttribute("class", "subject");
    var div = document.createElement('div');
    div.setAttribute("class", "subject-name");
    div.innerText = subject;
    
    var img = document.createElement('img');
    img.setAttribute("class", "form__img");
    img.src = "../img/delete-24.png";
    img.setAttribute("onclick", "deleteSubject(\'"+subject+"\')");
    
    divMain.appendChild(div);
    divMain.appendChild(img);
    document.getElementById("form__list").appendChild(divMain);
    document.getElementById("subject-new").value = "";
}


//Delete Subject
function deleteSubject(subjectId)
{
    var subject = document.getElementById(subjectId);
    subject.parentNode.removeChild(subject);
}


//Save Subjects
function collectData()
{
    var kidsName = [];
    var subjects = [];
    
    $(".kid:checked").each(function()
    {
        kidsName.push($(this).val());      
    });

    $(".subject_name").each(function()
    {
        subjects.push($(this).text());      
    });

    var kidsNameJSON = JSON.stringify(kidsName);
    var subjectsJSON = JSON.stringify(subjects);
    
    saveSubjects(kidsNameJSON, subjectsJSON);
}


//Save Subjects in Database
function saveSubjects(arrKidsName, arrSubjects)
{
    var kidsName = arrKidsName;
    var subjects = arrSubjects;
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState === 4 && this.status === 200)
        {
            alert(this.responseText);
        };
    };
    xhttp.open("POST", "services/do_add_subjects.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("kidsName="+kidsName+"&subjects="+subjects);
};

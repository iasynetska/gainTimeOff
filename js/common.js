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

$(window).ready(function()
    {
        changeCaptchaSize();
    }
);

$(window).resize(function()
    {
        changeCaptchaSize();
    }
);


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
    var subject = document.getElementById("subject").value;
    
    var divMain = document.createElement('div');
    divMain.setAttribute("id", subject);
    var div = document.createElement('div');
    div.setAttribute("class", "subject-name");
    div.innerText = subject;
    
    
    var img = document.createElement('img');
    img.src = "../img/delete-24.png";
    img.setAttribute("onclick", "deleteSubject(\'"+subject+"\')");
    
    divMain.appendChild(div);
    divMain.appendChild(img);
    document.getElementById("form__list").appendChild(divMain);
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

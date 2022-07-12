require('./bootstrap');

// 
window.deleteApi = function(id) {
    if (confirm("Are you sure you want to delete this post?")) {
        var r = new XMLHttpRequest();         	
        r.open("DELETE", "/api/posts/" + id, true);          	
        r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        r.send("_token=" + token + "&id=" + id);     	
        r.onreadystatechange = function() {     	
            if(this.readyState == 4 && this.status == 200) {
                document.getElementById('divGeneralMessages').classList.remove('d-none');
                document.getElementById('generalMessages').innerHTML = JSON.parse(r.responseText).success;
                let thisCard = document.querySelector('[data-id="' + id + '"]');
                thisCard.remove();
            }      
        };
    }          	
};

window.editApi = function(id) {
    let inputDesc = document.getElementById('inputDescription-' + id);
    actualtext = inputDesc.value;
    inputDesc.style.border = '1px solid gray';
    inputDesc.style.display = 'block';
    inputDesc.style.backgroundColor = '#d2edfc'; 
    inputDesc.removeAttribute('readonly');
    inputDesc.removeAttribute('disabled');
    inputDesc.focus();
    document.querySelector('[data-id="editButtonDiv-'+ id +'"]').style.display = 'block';
};

window.sendUpdateReq = function(id) {
    let inputDesc = document.getElementById('inputDescription-' + id);
    var r = new XMLHttpRequest();         	
    r.open("PUT", "/api/posts/" + id, true);          	
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("_token=" + token + "&description=" + inputDesc.value);     	
    r.onreadystatechange = function() {     	
        if(this.readyState == 4 && this.status == 200) {    	
            document.getElementById('divMessages-'+id).classList.remove('d-none');
            document.getElementById('messages-'+id).innerHTML = JSON.parse(r.responseText).success;
            inputDesc.setAttribute('readonly', 'true');
            inputDesc.setAttribute('disabled', 'true');
            inputDesc.style.border = 'none';
            inputDesc.style.backgroundColor = '#fff';
        }      
    }; 
    inputDesc.innerText = inputDesc.value;
    document.querySelector('[data-id="editButtonDiv-'+ id +'"]').setAttribute('style', 'display:none !important');
    onload();
}


window.cancel = function(id) {
    let inputDesc = document.getElementById('inputDescription-' + id)
    inputDesc.setAttribute('readonly', 'true');
    inputDesc.setAttribute('disabled', 'true');
    document.querySelector('[data-id="editButtonDiv-'+ id +'"]').setAttribute('style', 'display:none !important');
    inputDesc.value = actualtext;
    inputDesc.style.border = 'none';
    inputDesc.style.backgroundColor = '#fff';
}

window.onload = function() {
    const textAreas = document.querySelectorAll('.postTextArea');
    textAreas.forEach(textArea => {
        textArea.style.height = 'auto';
        textArea.style.height = (textArea.scrollHeight) + 'px';
    });
}

window.likes = function(id, postId, username) {
    let r = new XMLHttpRequest(); 	
    r.open("POST", "api/likes", true);          	
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("_token=" + token + "&user_id=" + id + "&post_id=" + postId + "&users_username=" + username);    	
    r.onreadystatechange = function() { 
        let response = r.responseText;
        // console.log(response.includes('deleted'));    	
        if(this.readyState == 4 && this.status == 200) {    	
            const heart = document.getElementById("heart_like-" + postId);
            const likeText = document.getElementById("likeText-" + postId);
            heart.classList.toggle('fa-heart-o');
            heart.classList.toggle('fa-heart');
           if (response.includes('added')) {
                likeText.innerHTML = 'Dislike';
                if (document.getElementById('othersLike-' + postId).innerText != '') document.getElementById('youLike-' + postId).innerHTML = '<b>You</b> and ';
                else document.getElementById('youLike-' + postId).innerHTML = '<b>You</b>';
                    if (document.getElementById('finalText-' + postId).innerText == '') document.getElementById('finalText-' + postId).innerHTML = 'like this post!';
           } else if (response.includes('deleted')){
               likeText.innerHTML = 'Like';
               document.getElementById('youLike-' + postId).innerHTML = '';
               if (document.getElementById('othersLike-' + postId).innerText == '') document.getElementById('finalText-' + postId).innerHTML = '';
           }
           document.getElementById("likeText-" + postId).innerText;
           document.getElementById("heart_like-" + postId).style.animation = 'zoom 1.5s 1';
           setTimeout(() => {
               document.getElementById("heart_like-" + postId).style.animation = '';
                },1500);
            } 
        };       
    }; 

window.sendToModal = function(postId) {
    var r = new XMLHttpRequest();         	
    r.open("GET", "api/likes/"+postId, true);          	
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send();    
    r.onreadystatechange = function() {     	
        if(this.readyState == 4 && this.status == 200) {    	
            // console.log(r.responseText);
            let obj = JSON.parse(r.responseText);
            let list = document.getElementById("usersList");
            list.innerHTML = "";
            for (let i = 0; i < obj.likes.length; i++) {
                console.log(obj.likes[i].users_username);
                let li = document.createElement("li");
                li.innerText = obj.likes[i].users_username;
                list.appendChild(li);
            }
        };       
    }
}

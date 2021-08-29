"use strict"

document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('form');
  form.addEventListener('submit', formSend);

  async function formSend(e) {
    e.preventDefault();

    let error = formValidate(form);

    let formData = new formData(form);
    formData.append('image', formImage.files[0]);

    if (error === 0) {
      form.classList.add('_sending');
      let response = await fetch('sendmail.php', {
        method: 'POST',
        body: formData
      });
      if (response.ok) {
        let result = await response.json();
        alert(result.message);
        formPreview.innerHTML = '';
        form.reset();
        form.classList.remove('_sending');
      } else {
        alert("Ошибка");
        form.classList.remove('_sending');
      }
    }else{
      alert('Заполните обязательные поля');
    }

  }


  function formValidate(form) {
    let error = 0;
    let formReq = document.querySelectorAll('._req');

    for (let index = 0; index < formReq.length; index++) {
      const input = formReq[index];
      formRemoveError(input);

      if (input.classList.contains('_email')) {
        if (emailTest(input)) {
          formAddError(input);
          error++;
        }
      } else if (input.getAttribute("type") === "checkbox" && input.checked === false) {
          formAddError(input);
          error++;
      } else {
          if (input.value === '') {
            formAddError(input);
            error++;
          }
      }
    }
    return error;
  }
  function formAddError(input) {
    input.parentElement.classList.add('_error');
    input.classList.add('_error');
  }
  function formRemoveError(input) {
    input.parentElement.classList.remove('_error');
    input.classList.remove('_error');
  }

  function emailTest(input) {
    return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
  }


  const formImage = document.getElementById('formImage');

  const formPreview = document.getElementById('formPreview');


  formImage.addEventListener('change', () => {
    uploadFile(formImage.files[0]);
  });

  function uploadFile(file) {

    if(!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
      alert('Разрешены только изображения!');
      formImage.value = '';
      return;
    }

    if (file.size > 2 * 1024 * 1024) {
      alert('Файл не должен превышать 2 мб!');
      return;
    }

    var reader = new FileReader();
    reader.onload = function (e) {
      formPreview.innerHTML = `<img src="${e.target.result}" alt="Фото">`;
    };
    reader.onerror = function (e) {
      alert('Ошибка');
    };
    reader.readAsDataURL(file);
  }
});


function smoothLinkScroll() {
  const btns = document.querySelectorAll('a[href*="#"]');

  for (let btn of btns) {
    btn.addEventListener('click', function(event) {
      event.preventDefault();
      const blockID = btn.getAttribute('href');
      document.querySelector('' + blockID).scrollIntoView({
        behavior: "smooth",
        block: "start"
      })
    })
  }
}

smoothLinkScroll();

function closeCallbackPopup() {
  const closeBtn = document.querySelector('.callbackForm__closeBtn');
  const popup = document.querySelector('.popupCallback');

  closeBtn.addEventListener("click", function() {
    popup.style.display = "none";
  })
}

closeCallbackPopup();

function callbackPopup() {
  const callbackBtn = document.querySelector(".header__callback-btn");
  const popup = document.querySelector('.popupCallback');

  callbackBtn.addEventListener('click', function() {
    popup.style.display = "block";
  })
}

callbackPopup();

function openHeaderMenu() {
  const btn = document.querySelector(".header__navBtn");
  const menu = document.querySelector(".header__nav");
  const logo = document.querySelector(".header__logo");

  btn.addEventListener("click", function() {
    btn.classList.toggle("headerMenuActive");
    menu.classList.toggle("openMenu");
    logo.classList.toggle("displayNone");
  });
}

openHeaderMenu();

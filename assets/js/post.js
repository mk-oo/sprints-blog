"use strict";
let apiUrl = "api";
let likePost = async (id) => {
  document
    .querySelector(`#likes_btn_${id}`)
    .setAttribute("disabled", "disabled");
  try {
    let req = await fetch(`${apiUrl}/like.php?id=${id}`);
    if (!req.ok) throw "Request not found";
    console.log(req);
    await req;
    let oldCount = +document.querySelector(`#likes_count_${id}`).innerHTML;
    document.querySelector(`#likes_count_${id}`).innerHTML = oldCount + 1;
    document.querySelector(`#likes_btn_${id}`).style.display = "none";
    document.querySelector(`#unlikes_btn_${id}`).style.display = "block";
  } catch (ex) {
    console.log(ex);
  } finally {
    document.querySelector(`#likes_btn_${id}`).removeAttribute("disabled");
  }
};

let unLikePost = async (id) => {
  document
    .querySelector(`#unlikes_btn_${id}`)
    .setAttribute("disabled", "disabled");
  try {
    let req = await fetch(`${apiUrl}/unlike.php?id=${id}`);
    if (!req.ok) throw "Request not found";
    console.log(req);
    await req;
    let oldCount = +document.querySelector(`#likes_count_${id}`).innerHTML;
    if (oldCount <= 1) oldCount = 1;
    document.querySelector(`#likes_count_${id}`).innerHTML = oldCount - 1;
    document.querySelector(`#likes_btn_${id}`).style.display = "block";
    document.querySelector(`#unlikes_btn_${id}`).style.display = "none";
  } catch (ex) {
    console.log(ex);
  } finally {
    document.querySelector(`#unlikes_btn_${id}`).removeAttribute("disabled");
  }
};

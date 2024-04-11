export const preventGoBack = () => {
  history.pushState(null, null, location.href);
  window.onpopstate = () => {
    alert("امکان بازگشت به عقب وجود ندارد.");
    history.go(1);
  };
};

export const allowGoBack = () => {
  window.onpopstate = () => {};
};

export const preventReload = () => {
  window.onbeforeunload = function () {
    return "This is a kind of cheating!";
  };
};

export const allowReload = () => {
  window.onbeforeunload = "";
};

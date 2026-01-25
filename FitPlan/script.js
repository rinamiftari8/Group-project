document.getElementById("userForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const formData = new FormData();
  formData.append("name", name.value);
  formData.append("email", email.value);

  fetch("save_user.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.text())
  .then(data => alert("User saved successfully 💚"));
});


// EDIT
document.querySelectorAll(".btn-edit").forEach((btn) => {
  btn.onclick = () => {
    const tr = btn.closest("tr");
    document.getElementById("edit-id").value = tr.dataset.id;
    document.getElementById("edit-name").value =
      tr.querySelector(".u-name").innerText;
    document.getElementById("edit-email").value =
      tr.querySelector(".u-email").innerText;
    document.getElementById("editModal").style.display = "block";
  };
});

// CANCEL
document.getElementById("cancelEdit").onclick = () => {
  document.getElementById("editModal").style.display = "none";
};

// SAVE
document.getElementById("editForm").onsubmit = (e) => {
  e.preventDefault();
  fetch("edit_user.php", {
    method: "POST",
    body: new FormData(e.target),
  })
    .then((r) => r.json())
    .then((d) => {
      if (d.success) location.reload();
      else alert("Edit failed");
    });
};

// DELETE
document.querySelectorAll(".btn-delete").forEach((btn) => {
  btn.onclick = () => {
    if (!confirm("Delete user?")) return;
    const fd = new FormData();
    fd.append("id", btn.dataset.id);

    fetch("delete_user.php", { method: "POST", body: fd })
      .then((r) => r.json())
      .then((d) => {
        if (d.success) btn.closest("tr").remove();
      });
  };
});

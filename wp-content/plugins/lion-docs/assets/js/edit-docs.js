/**
 * JQuery to handle when the icons are clicked on the Edit Menu page.
 * Set POST var's to the data-id of it's parent section / item.
 * Also sets form values when EDIT is clicked on an item.
 * The .parent() / .sibling() paths start from the icon that was clicked.
 */
jQuery(function ($) {
  // regex to match pattern of id-level for documents and groups (e.g. 5-2)
  $idLevelPattern = /\d+-\d+/;

  /**
   * When $(.iconClicked) {set hidden input value ready to parent item's ID for form submission}
   */
  function setPostVar($inputName, $caller) {
    $id = $($caller).parent().parent().attr("id");
    if ($inputName == "edit-default" && isNaN($id)) {
      $id = "insert"
    } else {
      $id = $id[0];
    };
    $("input[name=" + $inputName + "]").val($id);
  }

  /**
   * When $(.iconClicked) {set hidden input value ready to parent item's ID for form submission}
   */
  function setFilename($inputName, $caller) {
    $filename = $($caller).parent().siblings("td.filename").text();
    $("input[name=" + $inputName + "]").val($filename);
  }

  /**
   * Check value of hidden div
   * Tick publish checkbox if 1, leave unticked if 0
   */
  function setCheckbox($parentClassName, $childClassName, $caller) {
    $checked = $($caller)
      .parent()
      .siblings("." + $parentClassName)
      .children("." + $childClassName)
      .text();
    Number($checked) ?
      $("input[name=" + $parentClassName + "]").prop("checked", true) :
      $("input[name=" + $parentClassName + "]").prop("checked", false);

    return $checked;
  }

  /**
   * Check value of hidden div
   * Tick publish checkbox if 1, leave unticked if 0
   */
  function setGroupPublish($caller) {
    $checked = $($caller)
      .siblings(".publish-group")
      .children(".publish-value")
      .text();
    Number($checked) ?
      $("input[name=publish-group]").prop("checked", true) :
      $("input[name=publish-value]").prop("checked", false);

    return $checked;
  }

  /**
   * Set checkbox for edit subgroup
   */
  function setGroupSubgroup($caller) {
    $type = $($caller).parent().siblings(".group-type").children("span").text();

    if ($type === "Subgroup" || $type === "Subsubgroup") {
      $("input[name=is-sub-group]").prop("checked", true);
      $("#edit-parent-group").show();
    } else {
      $("input[name=is-sub-group]").prop("checked", false);
      $("#edit-parent-group").hide();
    }

    return $type;
  }

  /**
   * Set text input value to $inputName
   */
  function setDocTextInput($inputName, $caller) {
    $value = $($caller)
      .parent()
      .siblings("." + $inputName)
      .text();
    $("input[name=" + $inputName + "]").val($value);
  }

  /**
   * Set text input value to $inputName
   */
  function setGroupTextInput($inputName, $caller) {
    $value = $($caller).parent().siblings().children(".group-name").text();
    $("input[name=" + $inputName + "]").val($value);
  }

  /**
   * Set select input value for parent group
   */
  function setParentGroupSelect($caller) {
    $value = $($caller).parent().parent().parent().parent().attr("class");
    $value = $value.match($idLevelPattern);
    $("#edit-parent-group-input option[value=" + $value + "]").prop(
      "selected",
      true
    );
  }

  /**
   * Set currently selected file
   */
  function setFile($inputName, $caller) {
    $value = $($caller).parent().siblings(".filename").attr("data-file");
    $("#edit-file-select-input option[value=" + $value + "]").prop(
      "selected",
      true
    );
  }

  /**
   * Set select input (dropdown)
   */
  function setDocGroupSelect($caller) {
    $value = $($caller)
      .parent()
      .parent()
      .parent()
      .parent()
      .parent()
      .attr("class");
    $value = $value.match($idLevelPattern);
    $("#edit-group-select-input option[value=" + $value + "]").prop(
      "selected",
      true
    );
  }

  /**
   * Handle Add, Edit & Delete Forms
   */
  $(".create-doc").on("click", function () {
    $('input[name="doc-name"]').val("");
    $('input[name="publish-doc"]').prop("checked", true);
    $("#group-select-input option[value=0]").prop("selected", true);
    $("#file-select-input option[value=0]").prop("selected", true);
  });
  $(".edit-doc").on("click", function () {
    setPostVar("edit-doc", this);

    // Set form values to current item values
    setDocTextInput("doc-name", this);
    setDocGroupSelect(this);
    setFile("filename", this);
    setCheckbox("publish-doc", "publish-value", this);
  });
  $(".delete-doc").on("click", function () {
    setPostVar("delete-doc", this);
    setFilename("doc-filename", this);
  });

  /**
   * Handle Group Related Forms
   */
  $(".create-group").on("click", function () {
    $('input[name="group-name"]').val("");
    $('input[name="is-sub-group"]').prop("checked", false);
    $("#create-parent-group").hide();
    $("#create-parent-group-input option[value=0]").prop("selected", true);
    $('input[name="publish-group"]').prop("checked", true);
  });
  $(".edit-group").on("click", function () {
    setPostVar("edit-group", this);
    setGroupTextInput("group-name", this);
    setGroupPublish(this);
    setGroupSubgroup(this);
    setParentGroupSelect(this);
  });
  $(".delete-group").on("click", function () {
    setPostVar("delete-group", this);
  });

  /**
   * Handle Default Edit Form(s)
   */
  $(".edit-default").on("click", function () {
    setPostVar("edit-default", this);
  });

  /**
   * Toggle Parent Group select input when isSubGroup checkbox is selected
   */
  $("#create-is-sub-check").click(function () {
    $("#create-parent-group").toggle(this.unchecked);
  });
  $("#edit-is-sub-check").click(function () {
    $("#edit-parent-group").toggle(this.unchecked);
  });

  /**
   * Handle File Manager Forms
   */
  $(".custom-file-input").on("change", function () {
    $(".file-selected").html(
      "<i>" + this.value.replace("C:\\fakepath\\", "") + "</i>"
    );
  });
  $(".upload-file").on("click", function () {
    $(".file-selected").html("<i>No file selected...</i>");
  });
  $(".delete-file").on("click", function () {
    setPostVar("delete-file", this);
  });
});
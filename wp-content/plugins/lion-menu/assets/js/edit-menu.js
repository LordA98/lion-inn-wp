/**
 * JQuery to handle when the icons are clicked on the Edit Menu page.
 * Set POST var's to the data-id of it's parent section / item.
 * Also sets form values when EDIT is clicked on an item.
 * The .parent() / .sibling() paths start from the icon that was clicked.
 */
jQuery(function ($) {
  /**
   * When $(.iconClicked) {set hidden input value ready to parent item's ID for form submission}
   */
  function setPostVar($inputName, $caller) {
    $parentListItemId = $($caller)
      .closest("li")
      .data("id");
    $("input[name=" + $inputName + "]").val($parentListItemId);
  }

  /**
   * Handle 'Add Section' differently as no parent li
   * Get parent menu_id from URL
   */
  function setMenuId($inputName) {
    $parentMenuId = $(document).getUrlParam("menu_id");
    $("input[name=" + $inputName + "]").val($parentMenuId);
  }

  /**
   * Checking length of DOM item identifies if it exists
   * The span with .toPublish is only rendered if the item set to be published.
   */
  function setCheckbox($inputName, $className, $caller) {
    $checked = $($caller).siblings($className).length ? 1 : 0;
    $checked
      ?
      $("input[name=" + $inputName + "]").prop("checked", true) :
      $("input[name=" + $inputName + "]").prop("checked", false);

    return $checked;
  }

  /**
   * Set text input value to $inputName
   */
  function setTextInput($inputName, $caller) {
    $value = $($caller)
      .parent()
      .siblings("." + $inputName)
      .text();
    $("input[name=" + $inputName + "]").val($value);
  }

  /**
   * NOTE: Following three functions are specific to the
   * 'Edit Menu Name & Publish Status' button and accomponying form
   * on the Edit Menu subapge.
   * The current method isn't really very good, but I couldn't be bothered to
   * refactor everything to be better.
   */

  /**
   * When $(.iconClicked) {set hidden input value ready to parent item's ID for form submission}
   */
  function setPostVarFromButton($inputName, $caller) {
    $parentListItemId = $($caller)
      .parent()
      .siblings(".menu-id")
      .text();
    $("input[name=" + $inputName + "]").val($parentListItemId);
  }

  /**
   * Checking length of DOM item identifies if it exists
   * The span with .toPublish is only rendered if the item set to be published.
   */
  function setCheckboxFromButton($inputName, $caller) {
    $checked = $($caller)
      .parent()
      .siblings(".published")
      .text();
    $checked == 1 ?
      $("input[name=" + $inputName + "]").prop("checked", true) :
      $("input[name=" + $inputName + "]").prop("checked", false);

    return $checked;
  }

  /**
   * Set text input value to $inputName
   */
  function setTextInputFromButton($inputName, $caller) {
    $value = $($caller)
      .parent()
      .siblings(".menu-name")
      .text();
    $("input[name=" + $inputName + "]").val($value);
  }

  /**
   * Handle Add, Edit & Delete Forms
   */
  $(".add-menu").on("click", function () {
    $('input[name="menu-name"]').val("");
    $('input[name="publish-menu"]').prop("checked", true);
  });
  $(".edit-menu").on("click", function () {
    setPostVar("edit-menu", this);

    // Set form values to current item values
    setTextInput("menu-name", this);
    setCheckbox("publish-menu", ".toPublish", this);
  });
  $(".edit-menu-button").on("click", function () {
    setPostVarFromButton("edit-menu", this);

    // Set form values to current item values
    setTextInputFromButton("menu-name", this);
    setCheckboxFromButton("publish-menu", this);
  });
  $(".delete-menu").on("click", function () {
    setPostVar("delete-menu", this);
    setTextInput("menu-name", this);
  });

  $(".add-section").on("click", function () {
    setMenuId("add-section", this);
    // Ensure form values are empty
    $('input[name="section-name"]').val("");
    $('input[id="section-left-radio"]').prop("checked", true);
    $('input[id="section-right-radio"]').prop("checked", false);
    $('input[name="publish-section"]').prop("checked", true);
  });
  $(".edit-section").on("click", function () {
    setPostVar("edit-section", this);

    // Set form values to current item values
    setTextInput("section-name", this);

    $side = $(this)
      .parent()
      .siblings(".side")
      .text();
    $side == 1 ?
      $('input[id="section-right-radio"]').prop("checked", true) :
      $('input[id="section-left-radio"]').prop("checked", true);

    setCheckbox("publish-section", ".toPublish", this);
  });
  $(".delete-section").on("click", function () {
    setPostVar("delete-section", this);
    setTextInput("section-name", this);
  });

  $(".add-item").on("click", function () {
    setPostVar("add-item", this);
    // Ensure form values are empty
    $('input[name="item-name"]').val("");
    $('input[name="item-subsec"]').prop("checked", false);
    $('input[name="item-note"]').prop("checked", false);
    $('input[name="publish-item"]').prop("checked", true);
    $('input[name="item-price"]').val("");
    $('textarea[name="item-desc"]').val("");
    $('input[name="item-veg"]').prop("checked", false);
    $('input[name="item-gf"]').prop("checked", false);
    $('input[name="item-vegan"]').prop("checked", false);

    // Ensure all form inputs are being shown
    $(".hideIfSubsec").show(this.unchecked);
    $(".hideIfNote").show(this.unchecked);
  });
  $(".edit-item").on("click", function () {
    setPostVar("edit-item", this);

    // Set form values to current item values
    setTextInput("item-name", this);
    setCheckbox("publish-item", ".toPublish", this);
    $subsec = setCheckbox("item-subsec", ".isSubsec", this);
    $note = setCheckbox("item-note", ".isNote", this);

    // Display relevant input fields depending on item type
    if ($subsec && !$note) {
      $(".hideIfNote").show(this.unchecked);
      $(".hideIfSubsec").hide(this.unchecked);
    } else if ($note && !$subsec) {
      $(".hideIfSubsec").show(this.unchecked);
      $(".hideIfNote").hide(this.unchecked);

      $desc = $(this)
        .parent()
        .siblings(".desc")
        .children("i")
        .text();
      $('textarea[name="item-desc"]').val($desc);
    } else {
      $(".hideIfSubsec").show(this.unchecked);
      $(".hideIfNote").show(this.unchecked);

      $price = $(this)
        .parent()
        .siblings(".veg-gf-price")
        .children(".price")
        .text();
      // Remove symbols
      $price = $price.replace("£", "");
      $price = $price.replace("p", "");
      // set value
      $('input[name="item-price"]').val($price);

      $desc = $(this)
        .parent()
        .siblings(".desc")
        .children("i")
        .text();
      $('textarea[name="item-desc"]').val($desc);

      $veg = $(this)
        .parent()
        .siblings(".veg-gf-price")
        .children(".veg-gf")
        .children(".veg-icon").length ?
        1 :
        0;
      $veg
        ?
        $('input[name="item-veg"]').prop("checked", true) :
        $('input[name="item-veg"]').prop("checked", false);

      $gf = $(this)
        .parent()
        .siblings(".veg-gf-price")
        .children(".veg-gf")
        .children(".gf-icon").length ?
        1 :
        0;
      $gf
        ?
        $('input[name="item-gf"]').prop("checked", true) :
        $('input[name="item-gf"]').prop("checked", false);

      $vegan = $(this)
        .parent()
        .siblings(".veg-gf-price")
        .children(".veg-gf")
        .children(".vegan-icon").length ?
        1 :
        0;
      $vegan
        ?
        $('input[name="item-vegan"]').prop("checked", true) :
        $('input[name="item-vegan"]').prop("checked", false);
    }
  });
  $(".delete-item").on("click", function () {
    setPostVar("delete-item", this);
    setTextInput("item-name", this);
  });

  $(".add-subitem").on("click", function () {
    setPostVar("add-subitem", this);
    $('input[name="subitem-name"]').val("");
    $('input[name="subitem-price"]').val("");
    $('input[name="publish-subitem"]').prop("checked", true);
  });
  $(".edit-subitem").on("click", function () {
    setPostVar("edit-subitem", this);

    // Set form values to current item values
    setTextInput("subitem-name", this);
    setTextInput("subitem-price", this);
    setCheckbox("publish-subitem", ".toPublish", this);
  });
  $(".delete-subitem").on("click", function () {
    setPostVar("delete-subitem", this);
    setTextInput("subitem-name", this);
  });

  // If Subsection Title checkbox is clicked, hide all other inputs
  $("#add-subsec-check").click(function () {
    $(".hideIfSubsec").toggle(this.unchecked);
  });
  $("#edit-subsec-check").click(function () {
    $(".hideIfSubsec").toggle(this.unchecked);
  });

  // If Note checkbox is ticked, hide inputs
  $("#add-note-check").click(function () {
    $(".hideIfNote").toggle(this.unchecked);
  });
  $("#edit-note-check").click(function () {
    $(".hideIfNote").toggle(this.unchecked);
  });
});
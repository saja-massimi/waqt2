//*******************************Manage Copouns**************************************************************
document.getElementById("couponForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const couponCode = document.querySelector('input[name="coupon_code"]').value;

  fetch("./controllers/couponController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({ coupon_code: couponCode, coupon: true }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        document.querySelector('h6[name="copoun"]').innerHTML =
          "Coupon Discount";
        document.querySelector('h6[name="copoun_value"]').innerHTML =
          "- " + data.discount * 100 + " %";
        document.querySelector('h5[name="total"]').innerHTML =
          data.discounted_total + " JD";

        if (data.discounted_total <= 10) {
          Swal.fire({
            icon: "error",
            title: "Invalid Coupon",
            text: "You can't use the coupon because the total is less than 10 JD",
            showConfirmButton: true,
            confirmButtonText: "OK",
            customClass: { confirmButton: "btn btn-danger" },
            buttonsStyling: false,
          });
          return;
        }
        document.querySelector('input[name="order_total"]').value =
          Math.round(data.discounted_total / 2) * 2 + " JD";
        Swal.fire({
          icon: "success",
          title: "Coupon Applied",
          text: "Your coupon has been successfully applied!",
          showConfirmButton: true,
          confirmButtonText: "OK",
          customClass: { confirmButton: "btn btn-success" },
          buttonsStyling: false,
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Invalid Coupon",
          text: data.message,
          showConfirmButton: true,
          confirmButtonText: "OK",
          customClass: { confirmButton: "btn btn-danger" },
          buttonsStyling: false,
        });
      }
    })
    .catch((error) => console.error("Error:", error));
});
//****************************Handle Order Submit************************************************************
document.addEventListener("DOMContentLoaded", function () {
  const orderForm = document.getElementById("orderForm");

  const shipToDifferentAddressCheckbox = document.getElementById(
    "shipToDifferentAddress"
  );
  const additionalAddressFields = document.getElementById(
    "additionalAddressFields"
  );
  const hiddenAddressField = orderForm.querySelector(
    'input[name="order_address"]'
  );

  shipToDifferentAddressCheckbox.addEventListener("change", function () {
    if (this.checked) {
      additionalAddressFields.innerHTML = `
                <div class="form-group">
                    <label for="altStreet">Street</label>
                    <input type="text" class="form-control" id="altStreet" placeholder="Alternative Street" name="altStreet" required>
                </div>

                <div class="form-group">
                    <label for="altCity">City</label>
                    <select class="custom-select" id="altCity" name="altCity" required>
                        <option value="irbid">Irbid</option>
                        <option value="jarash">Jarash</option>
                        <option value="ajloun">Ajloun</option>
                        <option value="aqaba">Aqaba</option>
                        <option value="madaba">Madaba</option>
                        <option value="mafraq">Mafraq</option>
                        <option value="zarqa">Zarqa</option>
                        <option value="amman">Amman</option>
                        <option value="balqa">Balqa</option>
                        <option value="karak">Karak</option>
                        <option value="tafileh">Tafileh</option>
                        <option value="maan">Ma'an</option>
                    </select>
                </div>`;
    } else {
      additionalAddressFields.innerHTML = "";
    }
  });

  //*****************************************Handle Order Submit************************************************************
  orderForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const cartTotalItems = document.getElementById("cartTotalItems").innerText;

    // Check if there are items in the cart before proceeding
    if (parseInt(cartTotalItems) <= 5) {
      Swal.fire({
        icon: "error",
        title: "Empty Cart",
        text: "You need to add at least one item to your cart before placing an order.",
        showConfirmButton: true,
        confirmButtonText: "OK",
        customClass: { confirmButton: "btn btn-danger" },
        buttonsStyling: false,
      });
      return;
    }

    if (shipToDifferentAddressCheckbox.checked) {
      const altStreet = document.getElementById("altStreet").value;
      const altCity = document.getElementById("altCity").value;
      hiddenAddressField.value = `${altStreet}, ${altCity}`;
    }

    const formData = new FormData(orderForm);
    formData.append("order", true);

    fetch("controllers/orderController.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Order Placed",
            text: "Your order has been successfully placed!",
            showConfirmButton: true,
            confirmButtonText: "OK",
            customClass: { confirmButton: "btn btn-success" },
            buttonsStyling: false,
          }).then(() => {
            window.location.href = "index.php";
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message,
            showConfirmButton: true,
            confirmButtonText: "OK",
            customClass: { confirmButton: "btn btn-danger" },
            buttonsStyling: false,
          });
        }
      })
      .catch((error) => console.error("Error:", error));
  });
});

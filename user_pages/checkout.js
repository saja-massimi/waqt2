document.getElementById("shipToDifferentAddress").addEventListener("change", function () {
    const additionalFieldsContainer = document.getElementById("additionalAddressFields");

    if (this.checked) {
        additionalFieldsContainer.innerHTML = `
            <div class="form-group">
                <label>Street Address</label>
                <input type="text" class="form-control" name="shipping_street" placeholder="123 Street">
            </div>
            <div class="col-md-6 form-group">
            <label>City</label>
            <select class="custom-select form-contril">
                <option value="irbid '' >Irbid</option>
                <option value="jarash">Jarash</option>
                <option value="ajloun">Ajloun</option>
                <option value="aqaba" >al-'Aqaba</option>
                <option value="madaba" >Madaba</option>
                <option value="mafraq">al-Mafraq</option>
                <option value="zarqa" >al-Zarqa</option>
                <option value="amman">Amman</option>
                <option value="balqa">al-Balqa</option>
                <option value="karak">al-Karak</option>
                <option value="tafileh">al-Tafilah</option>
                <option value="maan">Ma'an</option>
            </select>
        </div>
                
        `;
    } else {
        additionalFieldsContainer.innerHTML = '';
    }
});



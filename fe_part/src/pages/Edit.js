import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import api from '../api';
//import '../style/edit_product.css';
import '../style/add_product.css';


const EditProduct = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const [Item, setItem] = useState({
        pname: '',
        Price: '',
        des: '',
        uid: '1'
    });

    useEffect(() => {
        const fetchProducts = async () => {
            console.log('AAAAAAAAAAAAAAA');
            const response = await api.get(`/product/${id}`);
            setItem(response.data);
        };
        fetchProducts();
    },[id]);

    const handleChange = (event) => {
        const { name, value } = event.target;
        setItem(prevItem => ({
            ...prevItem,
            [name]: value
        }));
    };
    

    const handleSubmit = async (event) => {
        event.preventDefault();
        const formData = new FormData();
        formData.append('pname', Item.pname);
        formData.append('Price', Item.Price);
        formData.append('des', Item.des);
        formData.append('uid', Item.uid);
        await api.put(`/product/${id}`, formData);
        navigate('/');
    };

    return (
        <><a href="/">Return Home</a>

            <div>
                <form onSubmit={handleSubmit}>
                    <h2>Edit Product</h2>
                    <label htmlFor="pname" className="p_name">Item's Name:</label>
                    <input type="text" name="pname" id="pname" className="pname" value={Item.pname} onChange={handleChange} required /><br /><br />

                    <label htmlFor="Price" className="p_name">Item's Price:</label>
                    <input type="number" name="Price" id="Price" className="Price" value={Item.Price} onChange={handleChange} required /><span>(VND)</span><br /><br />

                    <label htmlFor="des" className="p_name">Item's Description:</label><br />
                    <textarea name="des" id="des" className="des" value={Item.des} onChange={handleChange} rows="5" style={{ width: '100%' }}></textarea><br /><br />

                    <button type="submit" name="btn_add" className="btn_add">Save</button><br /><br />
                </form>
            </div>
        </>
    );
};

export default EditProduct;

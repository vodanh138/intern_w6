import React, { useState } from 'react';
import api from '../api';
import { useNavigate } from 'react-router-dom';
//import axios from 'axios';
import '../style/add_product.css';


const Add = () => {
    const [newItem, setNewItem] = useState({
        pname: '',
        Price: '',
        des: '',
        uid: '1',
    });
    const navigate = useNavigate();

    const handleChange = (event) => {
        const { name, value } = event.target;
        setNewItem(prevItem => ({
            ...prevItem,
            [name]: value
        }));
    };

    const handleSubmit = async (event) => {
        event.preventDefault();
            const formData = new FormData();
            formData.append('add_name', newItem.pname);
            formData.append('add_price', newItem.Price);
            formData.append('add_des', newItem.des);
            formData.append('uid', newItem.uid);
            await api.post('/AddProcessing', formData);
            navigate('/');

    };

    return (
        <>
            <a href="/">Return Home</a>
            <div>
                <form onSubmit={handleSubmit}>
                    <h2>Add New Item</h2>
                    <label htmlFor="add_name" className="p_name">Item's Name:</label>
                    <input type="text" name="pname" id="add_name" className="add_name" value={newItem.pname} onChange={handleChange} required /><br /><br />

                    <label htmlFor="add_price" className="p_name">Item's Price:</label>
                    <input type="number" name="Price" id="add_price" className="add_price" value={newItem.Price} onChange={handleChange} required /><span>(VND)</span><br /><br />

                    <label htmlFor="add_des" className="p_name">Item's Description:</label><br />
                    <textarea name="des" id="add_des" className="add_des" value={newItem.des} onChange={handleChange} rows="5" style={{ width: '100%' }}></textarea><br /><br />

                    <button type="submit" name="btn_add" className="btn_add">Add</button><br /><br />
                </form>
            </div>
        </>
    );
};

export default Add;

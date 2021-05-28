import React, { useState, useEffect, } from "react";
import axios, { post } from "axios";
import AdminHeader from "./components/AdminHeader";
import "./scss/style.scss";
import 'antd/dist/antd.css';
import { Modal, Button, Form, Row, Col, Input, Upload, InputNumber } from 'antd';
import { ExclamationCircleOutlined } from '@ant-design/icons';
import { BASE_API_URL } from "./const";

const layout = {
  labelCol: {
    span: 6,
  },
  wrapperCol: {
    span: 18,
  },
};

const validateMessages = {
  required: '${label} is required!',
  types: {
    number: '${label} is not a valid number!',
  },
  number: {
    range: '${label} must be between ${min} and ${max}',
  },
};

const Manage = (props) => {
  
  const [form] = Form.useForm();
  const [products, setProducts] = useState([]);
  const [visible, setVisible] = useState(false);
  const [fileList, setFileList] = useState([]);
  const [crud, setCrud] = useState('');
  const [index, setIndex] = useState(0);
  const [conf, setConf] = useState(0);
  
  
  const getProducts = () => {
    let url = `${BASE_API_URL}/api/products`;
    
    axios.get(url).then(response => {
      setProducts(response.data.products);
    });
  }
  
  const editProduct = (event) => {
    setCrud('u');
    setIndex(event.target.dataset.key);
    showModal();
  }


  const removeProduct = (event) => {
      axios.get(`${BASE_API_URL}/api/products/${event.target.dataset.key}/delete`)
        .then(response => {
          if(response.data.success == true){
            getProducts();
          }          
        })
        .catch(error => {
            console.log(error);
        })  
    
  }  
  
  const confirm = () => {
    Modal.confirm({
      title: 'Confirm delete',
      icon: <ExclamationCircleOutlined />,
      content: 'Are you sure?',
      okText: 'OK',
      onOk: () => {setConf(1)},
      onCancel: () => {setConf(0)},
      cancelText: 'Cancel',
    });
  }

  const createProduct = (event) => {
    setCrud('c');
    showModal();
  }
  
  const showModal = () => {
    setVisible(true);
  };

  const saveModal = () => {
    hideModal()
  };

  const editModal = () => {
    hideModal()
  };

  const hideModal = () => {
    setVisible(false);
  };

  const onFinish = (values) => {
    
    let formData = new FormData();
    if(crud == 'c'){ 
      // add one or more of your files in FormData
      // again, the original file is located at the `originFileObj` key
      formData.append("image", fileList[0].originFileObj);
      formData.append("name", values['name']);
      formData.append("price", values['price']);
      formData.append("stock", values['stock']);
      
      axios.post(`${BASE_API_URL}/api/products/create`, formData, {
        headers: {
            'content-type': 'multipart/form-data'
        }
      })
        .then(response => {
          getProducts();
          setFileList([])
          form.setFieldsValue({
            name: "",
            price: "",
            stock: "",
          });
        })
        .catch(function(error) {
            console.log(error);
        })
    }else if(crud == 'u'){
			
      if (fileList[0].originFileObj != null){
        formData.append("image", fileList[0].originFileObj);
      }
	  //console.log(fileList[0].originFileObj);
      formData.append("name", values['name']);
      formData.append("price", values['price']);
      formData.append("stock", values['stock']);

      axios.post(`${BASE_API_URL}/api/products/update/`+index, formData, {
        headers: {
            'content-type': 'multipart/form-data'
        }
      })
        .then(response => {
          getProducts();
        })
        .catch(error => {
            console.log(error);
        })
      
    }else{

    }    
    hideModal();
  };
  
  const onChange = ({ fileList: newFileList }) => {
	  console.log("OnChange");
	  console.log(newFileList);
    setFileList(newFileList);
  
  };
  const onPreview = async file => {
      let src = file.url;
      if (!src) {
          src = await new Promise(resolve => {
              const reader = new FileReader();
              reader.readAsDataURL(file.originFileObj);
              reader.onload = () => resolve(reader.result);
          });
      }
      const image = new Image();
      image.src = src;
      const imgWindow = window.open(src);
      imgWindow.document.write(image.outerHTML);
  };

  
  useEffect(() =>{
    let oldData = products.filter(product => product.id == index);
    
    if(oldData.length > 0){
      if(crud == 'c'){
        setFileList([])
        form.setFieldsValue({
          name: "",
          price: "",
          stock: "",
        });
      }else if(crud == 'u'){
		  console.log("UseEffect");
		  console.log(oldData[0]["image"]);
	  let ddd = `${BASE_API_URL}/uploads/${oldData[0]["image"]}`;
		  console.log(ddd);
        setFileList([{uid:-1, status: 'done', url: ddd}]);
		console.log(fileList);
        form.setFieldsValue({
          name: oldData[0]["name"],
          price: oldData[0]["price"],
          stock: parseInt(oldData[0]["stock"]),
        });
      }else{

      }
      
    }   
    
    getProducts();

  }, [props, visible, crud])

  
  return (
    <div className="container">
      <AdminHeader />
      <br /><br /><br /><br />
      <div className="products">
          <Button onClick={createProduct} className="btn btn-create" type="primary">Create</Button>
          <table className="product_table">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  { products.map((product, index) => {
                      return (
                          <tr key={index + 1}>
                              <td>{index + 1}</td>
                              <td><img src={`${BASE_API_URL}/uploads/`+product.image} alt="image" /></td>
                              <td>{product.name}</td>
                              <td>$&nbsp;{parseFloat(product.price).toFixed(2)}</td>
                              <td>{product.stock}</td>
                              <td>
                                  <button className="edit" onClick={editProduct} data-key={product.id}>Edit</button>
                                  <button className="delete" onClick={removeProduct} data-key={product.id}>Delete</button>
                              </td>
                          </tr>
                      );
                  })}
              </tbody>
          </table>
      </div>
      <Modal
        title={crud === 'c' ? "Create" : crud === 'u' ? "View" : null}
        visible={visible}
        onOk={crud === 'c' ? saveModal : crud === 'u' ? editModal : null}
        onCancel={hideModal}
        okText="Save"
        cancelText="Cancel"
        footer={null}
        headStyle={{ display: 'none' }}
      > 
      <Form form={form} {...layout} onFinish={onFinish} validateMessages={validateMessages}>
        <Row>
          <Col lg={8} md={8} sm={8} xs={24}>            
            <Upload
                listType="picture-card"
                fileList={fileList}
                onChange={onChange}
                onPreview={onPreview}
                beforeUpload={()=>false}
            >
                {fileList.length < 1 && '+ Upload'}
            </Upload>
          </Col>
          <Col lg={16} md={16} sm={16} xs={24}>
            <Row>
              <Col lg={24} md={24} sm={24} xs={24}>
                <Form.Item 
                  label="Name" 
                  name="name" 
                  rules={[
                  {
                    required: true,
                  },
                ]}>
                  <Input placeholder="Shop name here" />
                </Form.Item>
              </Col>
              <Col lg={24} md={24} sm={24} xs={24}>
                <Form.Item 
                  label="Price" 
                  name="price"
                  rules={[
                  {
                    required: true,
                  },
                ]}>
                  <Input placeholder="Price here - ex: 0.00" />
                </Form.Item>
              </Col>
              <Col lg={24} md={24} sm={24} xs={24}>
                <Form.Item 
                  label="Stock" 
                  name="stock" 
                  rules={[
                  {
                    type: 'number',
                    min: 0,
                    required: true,
                  },
                ]}>
                  <InputNumber />
                </Form.Item>
              </Col>
              <Col lg={24} md={24} sm={24} xs={24}>
                <Form.Item wrapperCol={{ ...layout.wrapperCol, offset: 6 }}>
                  <Button type="primary" htmlType="submit" >Save</Button>
                  <Button type="default" htmlType="button" onClick={hideModal} >Cancel</Button>
                </Form.Item>
              </Col>
            </Row>
          </Col>
        </Row>
      </Form>
      </Modal>
    </div>
  );

}

export default Manage;

import React from 'react';

const Label = ({ children, required = false, htmlFor, className = '' }) => (
  <label className={className} htmlFor={htmlFor}>
    {children} {required && <span style={{ color: 'red' }}>*</span>}
  </label>
);

export default Label;

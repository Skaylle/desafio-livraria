import React from 'react';

const AccordionSelect = ({ id, title, showCollapse, setShowCollapse, children }) => (
  <div className="row mb-4 align-items-center">
    <div className="col-md-12 col-12">
      <div className="accordion" id={id}>
        <div
          className="accordion-item"
          style={{ border: '1px solid #dee2e6', borderRadius: '0.5rem', overflow: 'hidden' }}
        >
          <h2 className="accordion-header" id={`heading-${id}`}>
            <button
              type="button"
              className={`accordion-button${showCollapse ? '' : ' collapsed'}`}
              style={{ background: '#f8f9fa', fontWeight: 'bold' }}
              onClick={() => setShowCollapse((prev) => !prev)}
              aria-expanded={showCollapse}
              aria-controls={`collapse-${id}`}
            >
              {title}
            </button>
          </h2>
          <div
            id={`collapse-${id}`}
            className={`accordion-collapse collapse${showCollapse ? ' show' : ''}`}
            aria-labelledby={`heading-${id}`}
            data-bs-parent={`#${id}`}
          >
            <div className="accordion-body" style={{ background: '#fff' }}>
              {children}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
);

export default AccordionSelect;

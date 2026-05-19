import * as React from 'react';
import clsx from 'clsx';

export function Label({ className, ...props }: React.HTMLAttributes<HTMLLabelElement>) {
  return <label className={clsx('block text-sm font-medium text-slate-700', className)} {...props} />;
}
